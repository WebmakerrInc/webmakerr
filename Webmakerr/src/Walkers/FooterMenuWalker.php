<?php

namespace Webmakerr\Walkers;

use Walker_Nav_Menu;

class FooterMenuWalker extends Walker_Nav_Menu
{
    private int $sectionCount = 0;

    /**
     * @var array<int, string>
     */
    private array $sectionStack = [];

    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth + 1);

        if ($depth === 0) {
            $sectionId = $this->sectionStack[$depth] ?? null;
            $contentClasses = [
                'footer-accordion-panel',
                'max-h-0',
                'overflow-hidden',
                'opacity-0',
                'pointer-events-none',
                'transition-all',
                'duration-300',
                'ease-out',
                'md:max-h-none',
                'md:overflow-visible',
                'md:opacity-100',
                'md:pointer-events-auto',
                'md:transition-none',
            ];

            $contentClasses = apply_filters('webmakerr_footer_menu_content_classes', $contentClasses, $args, $depth);

            $output .= "\n{$indent}<div";

            if ($sectionId) {
                $output .= ' id="'.esc_attr($sectionId).'"';
            }

            $output .= ' class="'.esc_attr(implode(' ', array_unique($contentClasses))).'" data-footer-accordion-content aria-hidden="true">';

            $listClasses = [
                'mt-3',
                'space-y-2',
                'pb-4',
                'text-sm',
                'text-neutral-500',
                'md:mt-4',
                'md:pb-0',
            ];

            $listClasses = apply_filters('nav_menu_submenu_css_class', $listClasses, $args, $depth);

            $output .= "\n{$indent}\t<ul class=\"".esc_attr(implode(' ', array_unique($listClasses)))."\" role=\"list\">";
        } else {
            $listClasses = apply_filters('nav_menu_submenu_css_class', ['space-y-2'], $args, $depth);
            $output .= "\n{$indent}<ul class=\"".esc_attr(implode(' ', array_unique($listClasses)))."\" role=\"list\">";
        }
    }

    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth + 1);

        if ($depth === 0) {
            $output .= "\n{$indent}\t</ul>";
            $output .= "\n{$indent}</div>";
        } else {
            $output .= "\n{$indent}</ul>";
        }
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
        $title_markup = wp_kses_post($title);
        $title_text = wp_strip_all_tags($title);

        if ($depth === 0) {
            ++$this->sectionCount;
            $sectionId = 'footer-menu-section-'.$this->sectionCount;
            $hasChildren = in_array('menu-item-has-children', (array) $item->classes, true);

            if ($hasChildren) {
                $this->sectionStack[$depth] = $sectionId;
            } else {
                unset($this->sectionStack[$depth]);
            }

            $classes = [
                'footer-menu__group',
                'list-none',
                'border-b',
                'border-neutral-200',
                'py-4',
                'first:pt-0',
                'last:border-b-0',
                'md:border-none',
                'md:py-0',
            ];

            $classNames = implode(' ', array_unique(apply_filters('nav_menu_css_class', $classes, $item, $args, $depth)));

            $output .= "\n{$indent}<li class=\"".esc_attr($classNames).'" data-footer-accordion-item>';

            $atts = [
                'title' => ! empty($item->attr_title) ? $item->attr_title : '',
                'target' => ! empty($item->target) ? $item->target : '',
                'rel' => ! empty($item->xfn) ? $item->xfn : '',
                'href' => ! empty($item->url) ? $item->url : '',
                'class' => 'no-underline text-sm font-semibold text-neutral-900 transition-colors duration-200 ease-out hover:opacity-70 md:text-base',
            ];

            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

            $item_output  = $args->before ?? '';
            $item_output .= '<div class="flex items-center justify-between gap-4">';
            $item_output .= '<a'.$this->format_attributes($atts).'>';
            $item_output .= ($args->link_before ?? '').$title_markup.($args->link_after ?? '');
            $item_output .= '</a>';

            if ($hasChildren) {
                $item_output .= '<button type="button" class="md:hidden flex h-9 w-9 items-center justify-center rounded border border-neutral-200 text-neutral-500 transition-colors duration-200 ease-out hover:text-neutral-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-neutral-900" data-footer-accordion-trigger aria-expanded="false" aria-controls="'.esc_attr($sectionId).'">';
                $item_output .= '<span class="sr-only">'.esc_html(sprintf(__('Toggle %s menu', 'webmakerr'), $title_text)).'</span>';
                $item_output .= '<svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" data-footer-accordion-icon><path d="M8 3.25V12.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12.75 8H3.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                $item_output .= '</button>';
            }

            $item_output .= '</div>';
            $item_output .= $args->after ?? '';

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        } else {
            $classes = ['list-none'];
            $classNames = implode(' ', array_unique(apply_filters('nav_menu_css_class', $classes, $item, $args, $depth)));

            $output .= "\n{$indent}<li class=\"".esc_attr($classNames).'">';

            $atts = [
                'title' => ! empty($item->attr_title) ? $item->attr_title : '',
                'target' => ! empty($item->target) ? $item->target : '',
                'rel' => ! empty($item->xfn) ? $item->xfn : '',
                'href' => ! empty($item->url) ? $item->url : '',
                'class' => 'block no-underline text-sm text-neutral-500 transition-colors duration-200 ease-out hover:text-neutral-900',
            ];

            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

            $item_output  = $args->before ?? '';
            $item_output .= '<a'.$this->format_attributes($atts).'>';
            $item_output .= ($args->link_before ?? '').$title_markup.($args->link_after ?? '');
            $item_output .= '</a>';
            $item_output .= $args->after ?? '';

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
    }

    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $output .= "\n{$indent}</li>";
    }

    private function format_attributes(array $attributes): string
    {
        $formatted = '';

        foreach ($attributes as $attribute => $value) {
            if (empty($value) && $value !== '0') {
                continue;
            }

            if (is_array($value)) {
                $value = implode(' ', array_filter($value));
            }

            $formatted .= ' '.esc_attr($attribute).'="'.esc_attr($value).'"';
        }

        return $formatted;
    }
}
