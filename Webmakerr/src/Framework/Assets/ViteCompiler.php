<?php

namespace Webmakerr\Framework\Assets;

class ViteCompiler
{
    /**
     * @var array<int, string>
     */
    private array $assets = [];

    private ?string $editorStyle = null;

    public function registerAsset(string $asset): self
    {
        if (!in_array($asset, $this->assets, true)) {
            $this->assets[] = $asset;
        }

        return $this;
    }

    public function editorStyleFile(string $asset): self
    {
        $this->editorStyle = $asset;

        return $this;
    }

    public function enqueue(): void
    {
        foreach ($this->assets as $asset) {
            $this->enqueueAsset($asset);
        }
    }

    public function enqueueEditorAssets(): void
    {
        if (!$this->editorStyle) {
            return;
        }

        $handle = $this->buildHandle($this->editorStyle, 'editor-style');
        $uri = get_theme_file_uri($this->editorStyle);
        $path = get_theme_file_path($this->editorStyle);

        wp_enqueue_style($handle, $uri, [], $this->assetVersion($path));
    }

    private function enqueueAsset(string $asset): void
    {
        $handle = $this->buildHandle($asset);
        $uri = get_theme_file_uri($asset);
        $path = get_theme_file_path($asset);
        $version = $this->assetVersion($path);

        if ($this->isScript($asset)) {
            wp_enqueue_script($handle, $uri, [], $version, true);
            return;
        }

        wp_enqueue_style($handle, $uri, [], $version);
    }

    private function buildHandle(string $asset, string $suffix = ''): string
    {
        $base = 'webmakerr-' . sanitize_title($asset);

        if ($suffix !== '') {
            $base .= '-' . $suffix;
        }

        return $base;
    }

    private function assetVersion(string $path): ?string
    {
        if (file_exists($path)) {
            return (string) filemtime($path);
        }

        return null;
    }

    private function isScript(string $asset): bool
    {
        return str_ends_with($asset, '.js') || str_ends_with($asset, '.mjs');
    }
}
