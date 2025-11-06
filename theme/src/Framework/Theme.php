<?php

namespace Webmakerr\Framework;

use Webmakerr\Framework\Assets\ViteCompiler;

class Theme
{
    private static ?self $instance = null;

    /**
     * @var array<string, mixed>
     */
    private array $themeSupports = [];

    /**
     * @var array<string, string>
     */
    private array $menus = [];

    /**
     * @var array<int, string>
     */
    private array $features = [];

    private AssetManager $assetManager;
    private ThemeSupportManager $themeSupportManager;
    private MenuManager $menuManager;
    private FeatureManager $featureManager;

    private function __construct()
    {
        $this->assetManager = new AssetManager();
        $this->themeSupportManager = new ThemeSupportManager($this);
        $this->menuManager = new MenuManager($this);
        $this->featureManager = new FeatureManager($this);

        add_action('after_setup_theme', [$this, 'registerThemeSupport']);
        add_action('after_setup_theme', [$this, 'registerMenus']);
        add_action('after_setup_theme', [$this, 'bootFeatures']);
    }

    public static function instance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function assets(callable $callback): self
    {
        $callback($this->assetManager);

        return $this;
    }

    public function themeSupport(callable $callback): self
    {
        $callback($this->themeSupportManager);

        return $this;
    }

    public function menus(callable $callback): self
    {
        $callback($this->menuManager);

        return $this;
    }

    public function features(callable $callback): self
    {
        $callback($this->featureManager);

        return $this;
    }

    /**
     * @param string $feature
     * @param mixed $arguments
     */
    public function queueThemeSupport(string $feature, $arguments = null): void
    {
        $this->themeSupports[$feature] = $arguments;
    }

    public function queueMenu(string $location, string $description): void
    {
        $this->menus[$location] = $description;
    }

    public function queueFeature(string $class): void
    {
        if (!in_array($class, $this->features, true)) {
            $this->features[] = $class;
        }
    }

    public function registerThemeSupport(): void
    {
        foreach ($this->themeSupports as $feature => $arguments) {
            if (null === $arguments) {
                add_theme_support($feature);
                continue;
            }

            add_theme_support($feature, $arguments);
        }
    }

    public function registerMenus(): void
    {
        if (empty($this->menus)) {
            return;
        }

        register_nav_menus($this->menus);
    }

    public function bootFeatures(): void
    {
        foreach ($this->features as $class) {
            if (!class_exists($class)) {
                continue;
            }

            $feature = new $class();

            if (method_exists($feature, 'register')) {
                $feature->register();
            }
        }
    }
}

class AssetManager
{
    private ?ViteCompiler $compiler = null;

    public function withCompiler(ViteCompiler $compiler, callable $callback): self
    {
        $this->compiler = $compiler;
        $callback($compiler);

        return $this;
    }

    public function enqueueAssets(): self
    {
        if (!$this->compiler) {
            return $this;
        }

        add_action('wp_enqueue_scripts', function () {
            if ($this->compiler) {
                $this->compiler->enqueue();
            }
        });

        add_action('enqueue_block_editor_assets', function () {
            if ($this->compiler) {
                $this->compiler->enqueueEditorAssets();
            }
        });

        return $this;
    }
}

class ThemeSupportManager
{
    private Theme $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    /**
     * @param array|string $support
     */
    public function add($support): self
    {
        if (is_array($support)) {
            if ($this->isList($support)) {
                foreach ($support as $value) {
                    $this->add($value);
                }

                return $this;
            }

            foreach ($support as $feature => $arguments) {
                if (is_int($feature)) {
                    $this->theme->queueThemeSupport((string) $arguments);
                    continue;
                }

                $this->theme->queueThemeSupport($feature, $arguments);
            }

            return $this;
        }

        $this->theme->queueThemeSupport((string) $support);

        return $this;
    }

    private function isList(array $values): bool
    {
        return $values === array_values($values);
    }
}

class MenuManager
{
    private Theme $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    public function add(string $location, string $description): self
    {
        $this->theme->queueMenu($location, $description);

        return $this;
    }
}

class FeatureManager
{
    private Theme $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    public function add(string $class): self
    {
        $this->theme->queueFeature($class);

        return $this;
    }
}
