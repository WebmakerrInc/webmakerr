branding:
  typography:
    base_font_family:
      - Inter
      - ui-sans-serif
      - system-ui
      - -apple-system
      - BlinkMacSystemFont
      - "Segoe UI"
      - Roboto
      - "Helvetica Neue"
      - Arial
      - "Noto Sans"
      - sans-serif
      - "Apple Color Emoji"
      - "Segoe UI Emoji"
      - "Segoe UI Symbol"
      - "Noto Color Emoji"
    monospace_font_family:
      - "Roboto Mono"
      - ui-monospace
      - SFMono-Regular
      - Menlo
      - Monaco
      - Consolas
      - "Liberation Mono"
      - "Courier New"
      - monospace
    web_class_scale:
      h1-webs: { font_size: "4rem", line_height: "4.4rem", font_weight: 500 }
      h2-webs: { font_size: "3.5rem", line_height: "3.85rem", font_weight: 500 }
      h3-webs: { font_size: "2.5rem", line_height: "2.75rem", font_weight: 500 }
      h4-webs: { font_size: "1.5rem", line_height: "1.875rem", font_weight: 500 }
    docs_class_scale:
      h1-docs: { font_size: "1.5rem", line_height: "1.875rem", font_weight: 500 }
      h2-docs: { font_size: "1.125rem", line_height: "1.8rem", font_weight: 500 }
      h3-docs: { font_size: "1rem", line_height: "1.6rem", font_weight: 500 }
      h4-docs: { font_size: "0.875rem", line_height: "1.4rem", font_weight: 500 }
    core_heading_scale:
      h1-core: { font_size: "1.125rem", line_height: "1.75rem", font_weight: 500 }
      h2-core: { font_size: "1rem", line_height: "1.5rem", font_weight: 500 }
      h3-core: { font_size: "0.875rem", line_height: "1.25rem", font_weight: 500 }
    text_scales:
      txt-xlarge-plus: { font_size: "1.125rem", line_height: "1.8rem", font_weight: 500 }
      txt-xlarge: { font_size: "1.125rem", line_height: "1.8rem", font_weight: 400 }
      txt-large-plus: { font_size: "1rem", line_height: "1.6rem", font_weight: 500 }
      txt-large: { font_size: "1rem", line_height: "1.6rem", font_weight: 400 }
      txt-medium-plus: { font_size: "0.875rem", line_height: "1.4rem", font_weight: 500 }
      txt-medium: { font_size: "0.875rem", line_height: "1.4rem", font_weight: 400 }
      txt-small-plus: { font_size: "0.8125rem", line_height: "1.3rem", font_weight: 500 }
      txt-small: { font_size: "0.8125rem", line_height: "1.3rem", font_weight: 400 }
      txt-xsmall-plus: { font_size: "0.75rem", line_height: "1.2rem", font_weight: 500 }
      txt-xsmall: { font_size: "0.75rem", line_height: "1.2rem", font_weight: 400 }
      txt-compact-xlarge-plus: { font_size: "1.125rem", line_height: "1.25rem", font_weight: 500 }
      txt-compact-xlarge: { font_size: "1.125rem", line_height: "1.25rem", font_weight: 400 }
      txt-compact-large-plus: { font_size: "1rem", line_height: "1.25rem", font_weight: 500 }
      txt-compact-large: { font_size: "1rem", line_height: "1.25rem", font_weight: 400 }
      txt-compact-medium-plus: { font_size: "0.875rem", line_height: "1.25rem", font_weight: 500 }
      txt-compact-medium: { font_size: "0.875rem", line_height: "1.25rem", font_weight: 400 }
      txt-compact-small-plus: { font_size: "0.8125rem", line_height: "1.25rem", font_weight: 500 }
      txt-compact-small: { font_size: "0.8125rem", line_height: "1.25rem", font_weight: 400 }
      txt-compact-xsmall-plus: { font_size: "0.75rem", line_height: "1.25rem", font_weight: 500 }
      txt-compact-xsmall: { font_size: "0.75rem", line_height: "1.25rem", font_weight: 400 }
      code-label-plus: { font_size: "0.75rem", line_height: "0.9375rem", font_weight: 500, font_family: "Roboto Mono" }
      code-label: { font_size: "0.75rem", line_height: "0.9375rem", font_weight: 400, font_family: "Roboto Mono" }
      code-paragraph-plus: { font_size: "0.75rem", line_height: "1.2rem", font_weight: 500, font_family: "Roboto Mono" }
      code-paragraph: { font_size: "0.75rem", line_height: "1.2rem", font_weight: 400, font_family: "Roboto Mono" }
  colors:
    docs:
      light:
        bg:
          base: "rgba(255, 255, 255, 1)"
          base_hover: "rgba(244, 244, 245, 1)"
          base_pressed: "rgba(228, 228, 231, 1)"
          subtle: "rgba(250, 250, 250, 1)"
          subtle_hover: "rgba(244, 244, 245, 1)"
          subtle_pressed: "rgba(228, 228, 231, 1)"
          component: "rgba(250, 250, 250, 1)"
          component_hover: "rgba(244, 244, 245, 1)"
          component_pressed: "rgba(228, 228, 231, 1)"
          switch_off: "rgba(228, 228, 231, 1)"
          switch_off_hover: "rgba(212, 212, 216, 1)"
          interactive: "rgba(59, 130, 246, 1)"
          overlay: "rgba(24, 24, 27, 0.4)"
          disabled: "rgba(244, 244, 245, 1)"
          highlight: "rgba(239, 246, 255, 1)"
          highlight_hover: "rgba(219, 234, 254, 1)"
          field: "rgba(250, 250, 250, 1)"
          field_hover: "rgba(244, 244, 245, 1)"
          field_component: "rgba(255, 255, 255, 1)"
          field_component_hover: "rgba(250, 250, 250, 1)"
        fg:
          base: "rgba(24, 24, 27, 1)"
          subtle: "rgba(82, 82, 91, 1)"
          muted: "rgba(113, 113, 122, 1)"
          disabled: "rgba(161, 161, 170, 1)"
          on_color: "rgba(255, 255, 255, 1)"
          on_inverted: "rgba(255, 255, 255, 1)"
          interactive: "rgba(59, 130, 246, 1)"
          interactive_hover: "rgba(37, 99, 235, 1)"
          error: "rgba(225, 29, 72, 1)"
        border:
          base: "rgba(228, 228, 231, 1)"
          strong: "rgba(212, 212, 216, 1)"
          interactive: "rgba(59, 130, 246, 1)"
          error: "rgba(225, 29, 72, 1)"
          danger: "rgba(190, 18, 60, 1)"
          transparent: "rgba(255, 255, 255, 0)"
          menu_top: "rgba(228, 228, 231, 1)"
          menu_bottom: "rgba(255, 255, 255, 1)"
        button:
          inverted: { base: "rgba(39, 39, 42, 1)", hover: "rgba(63, 63, 70, 1)", pressed: "rgba(82, 82, 91, 1)" }
          neutral: { base: "rgba(255, 255, 255, 1)", hover: "rgba(244, 244, 245, 1)", pressed: "rgba(228, 228, 231, 1)" }
          danger: { base: "rgba(225, 29, 72, 1)", hover: "rgba(190, 18, 60, 1)", pressed: "rgba(159, 18, 57, 1)" }
          transparent: { base: "rgba(255, 255, 255, 0)", hover: "rgba(24, 24, 27, 0.06)", pressed: "rgba(228, 228, 231, 1)" }
        tag:
          neutral: { bg: "rgba(244, 244, 245, 1)", bg_hover: "rgba(228, 228, 231, 1)", text: "rgba(82, 82, 91, 1)", icon: "rgba(161, 161, 170, 1)", border: "rgba(228, 228, 231, 1)" }
          purple: { bg: "rgba(237, 233, 254, 1)", bg_hover: "rgba(221, 214, 254, 1)", text: "rgba(91, 33, 182, 1)", icon: "rgba(167, 139, 250, 1)", border: "rgba(221, 214, 254, 1)" }
          blue: { bg: "rgba(219, 234, 254, 1)", bg_hover: "rgba(191, 219, 254, 1)", text: "rgba(30, 64, 175, 1)", icon: "rgba(96, 165, 250, 1)", border: "rgba(191, 219, 254, 1)" }
          green: { bg: "rgba(209, 250, 229, 1)", bg_hover: "rgba(167, 243, 208, 1)", text: "rgba(6, 95, 70, 1)", icon: "rgba(16, 185, 129, 1)", border: "rgba(167, 243, 208, 1)" }
          orange: { bg: "rgba(255, 237, 213, 1)", bg_hover: "rgba(254, 215, 170, 1)", text: "rgba(154, 52, 18, 1)", icon: "rgba(249, 115, 22, 1)", border: "rgba(254, 215, 170, 1)" }
          red: { bg: "rgba(255, 228, 230, 1)", bg_hover: "rgba(254, 205, 211, 1)", text: "rgba(159, 18, 57, 1)", icon: "rgba(244, 63, 94, 1)", border: "rgba(254, 205, 211, 1)" }
        code:
          bg_base: "rgba(24, 24, 27, 1)"
          bg_header: "rgba(31, 41, 55, 1)"
          border: "rgba(55, 65, 81, 1)"
        contrast:
          bg_base: "rgba(24, 24, 27, 1)"
          bg_base_hover: "rgba(39, 39, 42, 1)"
          bg_base_pressed: "rgba(63, 63, 70, 1)"
          bg_subtle: "rgba(39, 39, 42, 1)"
          bg_highlight: "rgba(63, 63, 70, 1)"
          bg_alpha: "rgba(9, 9, 11, 0.8)"
          fg_primary: "rgba(255, 255, 255, 0.88)"
          fg_secondary: "rgba(255, 255, 255, 0.56)"
          border_base: "rgba(255, 255, 255, 0.16)"
          border_top: "rgba(9, 9, 11, 1)"
          border_bottom: "rgba(255, 255, 255, 0.10)"
        alpha:
          white_alpha_6: "rgba(255, 255, 255, 0.06)"
          white_alpha_12: "rgba(255, 255, 255, 0.12)"
          alphas_250: "rgba(24, 24, 27, 0.1)"
      dark:
        bg:
          base: "rgba(33, 33, 36, 1)"
          base_hover: "rgba(39, 39, 42, 1)"
          base_pressed: "rgba(63, 63, 70, 1)"
          subtle: "rgba(24, 24, 27, 1)"
          subtle_hover: "rgba(33, 33, 36, 1)"
          subtle_pressed: "rgba(39, 39, 42, 1)"
          component: "rgba(39, 39, 42, 1)"
          component_hover: "rgba(255, 255, 255, 0.1)"
          component_pressed: "rgba(255, 255, 255, 0.16)"
          switch_off: "rgba(63, 63, 70, 1)"
          switch_off_hover: "rgba(82, 82, 91, 1)"
          interactive: "rgba(96, 165, 250, 1)"
          overlay: "rgba(24, 24, 27, 0.72)"
          disabled: "rgba(39, 39, 42, 1)"
          highlight: "rgba(23, 37, 84, 1)"
          highlight_hover: "rgba(30, 58, 138, 1)"
          field: "rgba(255, 255, 255, 0.04)"
          field_hover: "rgba(255, 255, 255, 0.08)"
          field_component: "rgba(33, 33, 36, 1)"
          field_component_hover: "rgba(39, 39, 42, 1)"
        fg:
          base: "rgba(244, 244, 245, 1)"
          subtle: "rgba(161, 161, 170, 1)"
          muted: "rgba(113, 113, 122, 1)"
          disabled: "rgba(82, 82, 91, 1)"
          on_color: "rgba(255, 255, 255, 1)"
          on_inverted: "rgba(24, 24, 27, 1)"
          interactive: "rgba(96, 165, 250, 1)"
          interactive_hover: "rgba(147, 197, 253, 1)"
          error: "rgba(251, 113, 133, 1)"
        border:
          base: "rgba(255, 255, 255, 0.08)"
          strong: "rgba(255, 255, 255, 0.16)"
          interactive: "rgba(96, 165, 250, 1)"
          error: "rgba(251, 113, 133, 1)"
          danger: "rgba(190, 18, 60, 1)"
          transparent: "rgba(255, 255, 255, 0)"
          menu_top: "rgba(33, 33, 36, 1)"
          menu_bottom: "rgba(255, 255, 255, 0.08)"
        button:
          inverted: { base: "rgba(82, 82, 91, 1)", hover: "rgba(113, 113, 122, 1)", pressed: "rgba(161, 161, 170, 1)" }
          neutral: { base: "rgba(255, 255, 255, 0.04)", hover: "rgba(255, 255, 255, 0.08)", pressed: "rgba(255, 255, 255, 0.12)" }
          danger: { base: "rgba(159, 18, 57, 1)", hover: "rgba(190, 18, 60, 1)", pressed: "rgba(225, 29, 72, 1)" }
          transparent: { base: "rgba(255, 255, 255, 0)", hover: "rgba(255, 255, 255, 0.08)", pressed: "rgba(255, 255, 255, 0.12)" }
        tag:
          neutral: { bg: "rgba(255, 255, 255, 0.08)", bg_hover: "rgba(255, 255, 255, 0.12)", text: "rgba(212, 212, 216, 1)", icon: "rgba(113, 113, 122, 1)", border: "rgba(255, 255, 255, 0.06)" }
          purple: { bg: "rgba(46, 16, 101, 1)", bg_hover: "rgba(91, 33, 182, 1)", text: "rgba(196, 181, 253, 1)", icon: "rgba(167, 139, 250, 1)", border: "rgba(91, 33, 182, 1)" }
          blue: { bg: "rgba(23, 37, 84, 1)", bg_hover: "rgba(30, 58, 138, 1)", text: "rgba(147, 197, 253, 1)", icon: "rgba(96, 165, 250, 1)", border: "rgba(30, 58, 138, 1)" }
          green: { bg: "rgba(2, 44, 34, 1)", bg_hover: "rgba(6, 78, 59, 1)", text: "rgba(52, 211, 153, 1)", icon: "rgba(16, 185, 129, 1)", border: "rgba(6, 78, 59, 1)" }
          orange: { bg: "rgba(67, 20, 7, 1)", bg_hover: "rgba(124, 45, 18, 1)", text: "rgba(253, 186, 116, 1)", icon: "rgba(251, 146, 60, 1)", border: "rgba(124, 45, 18, 1)" }
          red: { bg: "rgba(76, 5, 25, 1)", bg_hover: "rgba(136, 19, 55, 1)", text: "rgba(253, 164, 175, 1)", icon: "rgba(251, 113, 133, 1)", border: "rgba(136, 19, 55, 1)" }
        code:
          bg_base: "rgba(9, 9, 11, 1)"
          bg_header: "rgba(24, 24, 26, 1)"
          border: "rgba(46, 48, 53, 1)"
        contrast:
          bg_base: "rgba(39, 39, 42, 1)"
          bg_base_hover: "rgba(63, 63, 70, 1)"
          bg_base_pressed: "rgba(82, 82, 91, 1)"
          bg_subtle: "rgba(47, 47, 50, 1)"
          bg_highlight: "rgba(82, 82, 91, 1)"
          bg_alpha: "rgba(63, 63, 70, 0.9)"
          fg_primary: "rgba(250, 250, 250, 1)"
          fg_secondary: "rgba(255, 255, 255, 0.56)"
          border_base: "rgba(82, 82, 91, 1)"
          border_top: "rgba(24, 24, 27, 1)"
          border_bottom: "rgba(255, 255, 255, 0.08)"
        alpha:
          alphas_250: "rgba(255, 255, 255, 0.1)"
    ui:
      light:
        bg:
          base: "rgba(255, 255, 255, 1)"
          base_hover: "rgba(244, 244, 245, 1)"
          base_pressed: "rgba(228, 228, 231, 1)"
          subtle: "rgba(250, 250, 250, 1)"
          subtle_hover: "rgba(244, 244, 245, 1)"
          subtle_pressed: "rgba(228, 228, 231, 1)"
          component: "rgba(250, 250, 250, 1)"
          component_hover: "rgba(244, 244, 245, 1)"
          component_pressed: "rgba(228, 228, 231, 1)"
          disabled: "rgba(244, 244, 245, 1)"
          highlight: "rgba(239, 246, 255, 1)"
          highlight_hover: "rgba(219, 234, 254, 1)"
          switch_off: "rgba(228, 228, 231, 1)"
          switch_off_hover: "rgba(212, 212, 216, 1)"
          field: "rgba(250, 250, 250, 1)"
          field_hover: "rgba(244, 244, 245, 1)"
          field_component: "rgba(255, 255, 255, 1)"
          field_component_hover: "rgba(250, 250, 250, 1)"
          interactive: "rgba(59, 130, 246, 1)"
          overlay: "rgba(24, 24, 27, 0.4)"
        fg:
          base: "rgba(24, 24, 27, 1)"
          subtle: "rgba(82, 82, 91, 1)"
          muted: "rgba(113, 113, 122, 1)"
          disabled: "rgba(161, 161, 170, 1)"
          on_color: "rgba(255, 255, 255, 1)"
          on_inverted: "rgba(255, 255, 255, 1)"
          interactive: "rgba(59, 130, 246, 1)"
          interactive_hover: "rgba(37, 99, 235, 1)"
          error: "rgba(225, 29, 72, 1)"
        border:
          base: "rgba(228, 228, 231, 1)"
          strong: "rgba(212, 212, 216, 1)"
          interactive: "rgba(59, 130, 246, 1)"
          error: "rgba(225, 29, 72, 1)"
          danger: "rgba(190, 18, 60, 1)"
          transparent: "rgba(255, 255, 255, 0)"
        button:
          inverted: { base: "rgba(39, 39, 42, 1)", hover: "rgba(63, 63, 70, 1)", pressed: "rgba(82, 82, 91, 1)" }
          neutral: { base: "rgba(255, 255, 255, 1)", hover: "rgba(244, 244, 245, 1)", pressed: "rgba(228, 228, 231, 1)" }
          danger: { base: "rgba(225, 29, 72, 1)", hover: "rgba(190, 18, 60, 1)", pressed: "rgba(159, 18, 57, 1)" }
          transparent: { base: "rgba(255, 255, 255, 0)", hover: "rgba(244, 244, 245, 1)", pressed: "rgba(228, 228, 231, 1)" }
        tag:
          neutral: { bg: "rgba(244, 244, 245, 1)", bg_hover: "rgba(228, 228, 231, 1)", text: "rgba(82, 82, 91, 1)", icon: "rgba(161, 161, 170, 1)", border: "rgba(228, 228, 231, 1)" }
          purple: { bg: "rgba(237, 233, 254, 1)", bg_hover: "rgba(221, 214, 254, 1)", text: "rgba(91, 33, 182, 1)", icon: "rgba(167, 139, 250, 1)", border: "rgba(221, 214, 254, 1)" }
          blue: { bg: "rgba(219, 234, 254, 1)", bg_hover: "rgba(191, 219, 254, 1)", text: "rgba(30, 64, 175, 1)", icon: "rgba(96, 165, 250, 1)", border: "rgba(191, 219, 254, 1)" }
          green: { bg: "rgba(209, 250, 229, 1)", bg_hover: "rgba(167, 243, 208, 1)", text: "rgba(6, 95, 70, 1)", icon: "rgba(16, 185, 129, 1)", border: "rgba(167, 243, 208, 1)" }
          orange: { bg: "rgba(255, 237, 213, 1)", bg_hover: "rgba(254, 215, 170, 1)", text: "rgba(154, 52, 18, 1)", icon: "rgba(249, 115, 22, 1)", border: "rgba(254, 215, 170, 1)" }
          red: { bg: "rgba(255, 228, 230, 1)", bg_hover: "rgba(254, 205, 211, 1)", text: "rgba(159, 18, 57, 1)", icon: "rgba(244, 63, 94, 1)", border: "rgba(254, 205, 211, 1)" }
        contrast:
          fg_primary: "rgba(255, 255, 255, 0.88)"
          fg_secondary: "rgba(255, 255, 255, 0.56)"
          bg_base: "rgba(24, 24, 27, 1)"
          bg_base_hover: "rgba(39, 39, 42, 1)"
          bg_base_pressed: "rgba(63, 63, 70, 1)"
          bg_subtle: "rgba(39, 39, 42, 1)"
          bg_highlight: "rgba(63, 63, 70, 1)"
          border_base: "rgba(255, 255, 255, 0.16)"
          border_top: "rgba(24, 24, 27, 1)"
          border_bottom: "rgba(255, 255, 255, 0.10)"
        alpha:
          alpha_250: "rgba(24, 24, 27, 0.1)"
          alpha_400: "rgba(24, 24, 27, 0.24)"
      dark:
        bg:
          base: "rgba(33, 33, 36, 1)"
          base_hover: "rgba(39, 39, 42, 1)"
          base_pressed: "rgba(63, 63, 70, 1)"
          subtle: "rgba(24, 24, 27, 1)"
          subtle_hover: "rgba(33, 33, 36, 1)"
          subtle_pressed: "rgba(39, 39, 42, 1)"
          component: "rgba(39, 39, 42, 1)"
          component_hover: "rgba(255, 255, 255, 0.1)"
          component_pressed: "rgba(255, 255, 255, 0.16)"
          disabled: "rgba(39, 39, 42, 1)"
          highlight: "rgba(23, 37, 84, 1)"
          highlight_hover: "rgba(30, 58, 138, 1)"
          switch_off: "rgba(63, 63, 70, 1)"
          switch_off_hover: "rgba(82, 82, 91, 1)"
          field: "rgba(255, 255, 255, 0.04)"
          field_hover: "rgba(255, 255, 255, 0.08)"
          field_component: "rgba(33, 33, 36, 1)"
          field_component_hover: "rgba(39, 39, 42, 1)"
          interactive: "rgba(96, 165, 250, 1)"
          overlay: "rgba(24, 24, 27, 0.72)"
        fg:
          base: "rgba(244, 244, 245, 1)"
          subtle: "rgba(161, 161, 170, 1)"
          muted: "rgba(113, 113, 122, 1)"
          disabled: "rgba(82, 82, 91, 1)"
          on_color: "rgba(255, 255, 255, 1)"
          on_inverted: "rgba(24, 24, 27, 1)"
          interactive: "rgba(96, 165, 250, 1)"
          interactive_hover: "rgba(147, 197, 253, 1)"
          error: "rgba(251, 113, 133, 1)"
        border:
          base: "rgba(255, 255, 255, 0.08)"
          strong: "rgba(255, 255, 255, 0.16)"
          interactive: "rgba(96, 165, 250, 1)"
          error: "rgba(251, 113, 133, 1)"
          danger: "rgba(190, 18, 60, 1)"
          transparent: "rgba(255, 255, 255, 0)"
        button:
          inverted: { base: "rgba(82, 82, 91, 1)", hover: "rgba(113, 113, 122, 1)", pressed: "rgba(161, 161, 170, 1)" }
          neutral: { base: "rgba(255, 255, 255, 0.04)", hover: "rgba(255, 255, 255, 0.08)", pressed: "rgba(255, 255, 255, 0.12)" }
          danger: { base: "rgba(159, 18, 57, 1)", hover: "rgba(190, 18, 60, 1)", pressed: "rgba(225, 29, 72, 1)" }
          transparent: { base: "rgba(255, 255, 255, 0)", hover: "rgba(255, 255, 255, 0.08)", pressed: "rgba(255, 255, 255, 0.12)" }
        tag:
          neutral: { bg: "rgba(255, 255, 255, 0.08)", bg_hover: "rgba(255, 255, 255, 0.12)", text: "rgba(212, 212, 216, 1)", icon: "rgba(113, 113, 122, 1)", border: "rgba(255, 255, 255, 0.06)" }
          purple: { bg: "rgba(46, 16, 101, 1)", bg_hover: "rgba(91, 33, 182, 1)", text: "rgba(196, 181, 253, 1)", icon: "rgba(167, 139, 250, 1)", border: "rgba(91, 33, 182, 1)" }
          blue: { bg: "rgba(23, 37, 84, 1)", bg_hover: "rgba(30, 58, 138, 1)", text: "rgba(147, 197, 253, 1)", icon: "rgba(96, 165, 250, 1)", border: "rgba(30, 58, 138, 1)" }
          green: { bg: "rgba(2, 44, 34, 1)", bg_hover: "rgba(6, 78, 59, 1)", text: "rgba(52, 211, 153, 1)", icon: "rgba(16, 185, 129, 1)", border: "rgba(6, 78, 59, 1)" }
          orange: { bg: "rgba(67, 20, 7, 1)", bg_hover: "rgba(124, 45, 18, 1)", text: "rgba(253, 186, 116, 1)", icon: "rgba(251, 146, 60, 1)", border: "rgba(124, 45, 18, 1)" }
          red: { bg: "rgba(76, 5, 25, 1)", bg_hover: "rgba(136, 19, 55, 1)", text: "rgba(253, 164, 175, 1)", icon: "rgba(251, 113, 133, 1)", border: "rgba(136, 19, 55, 1)" }
        contrast:
          fg_primary: "rgba(250, 250, 250, 1)"
          fg_secondary: "rgba(255, 255, 255, 0.56)"
          bg_base: "rgba(39, 39, 42, 1)"
          bg_base_hover: "rgba(63, 63, 70, 1)"
          bg_base_pressed: "rgba(82, 82, 91, 1)"
          bg_subtle: "rgba(47, 47, 50, 1)"
          bg_highlight: "rgba(82, 82, 91, 1)"
          border_base: "rgba(82, 82, 91, 1)"
          border_top: "rgba(24, 24, 27, 1)"
          border_bottom: "rgba(255, 255, 255, 0.08)"
        alpha:
          alpha_250: "rgba(255, 255, 255, 0.1)"
          alpha_400: "rgba(255, 255, 255, 0.24)"

  buttons:
    variants:
      primary:
        size_tokens: { small: "txt-compact-small-plus gap-x-1.5 px-2 py-1", base: "txt-compact-small-plus gap-x-1.5 px-3 py-1.5", large: "txt-compact-medium-plus gap-x-1.5 px-4 py-2.5", xlarge: "txt-compact-large-plus gap-x-1.5 px-5 py-3.5" }
        light: { background: "rgba(39, 39, 42, 1)", hover_background: "rgba(63, 63, 70, 1)", active_background: "rgba(82, 82, 91, 1)", text: "rgba(255, 255, 255, 0.88)", focus_shadow: "0px 0.75px 0px 0px rgba(255, 255, 255, 0.2) inset, 0px 1px 2px 0px rgba(0, 0, 0, 0.4), 0px 0px 0px 1px rgba(24, 24, 27, 1), 0px 0px 0px 2px rgba(255, 255, 255, 1), 0px 0px 0px 4px rgba(59, 130, 246, 0.6)" }
        dark: { background: "rgba(82, 82, 91, 1)", hover_background: "rgba(113, 113, 122, 1)", active_background: "rgba(161, 161, 170, 1)", text: "rgba(255, 255, 255, 1)", focus_shadow: "0px -1px 0px 0px rgba(255, 255, 255, 0.12), 0px 0px 0px 1px rgba(255, 255, 255, 0.12), 0px 0px 0px 1px rgba(82, 82, 91, 1), 0px 0px 0px 2px rgba(24, 24, 27, 1), 0px 0px 0px 4px rgba(96, 165, 250, 0.8)" }
      secondary:
        size_tokens: { small: "txt-compact-small-plus gap-x-1.5 px-2 py-1", base: "txt-compact-small-plus gap-x-1.5 px-3 py-1.5", large: "txt-compact-medium-plus gap-x-1.5 px-4 py-2.5", xlarge: "txt-compact-large-plus gap-x-1.5 px-5 py-3.5" }
        light: { background: "rgba(255, 255, 255, 1)", hover_background: "rgba(244, 244, 245, 1)", active_background: "rgba(228, 228, 231, 1)", text: "rgba(24, 24, 27, 1)", focus_shadow: "0px 1px 2px 0px rgba(0, 0, 0, 0.12), 0px 0px 0px 1px rgba(0, 0, 0, 0.08), 0px 0px 0px 2px rgba(255, 255, 255, 1), 0px 0px 0px 4px rgba(59, 130, 246, 0.6)" }
        dark: { background: "rgba(255, 255, 255, 0.04)", hover_background: "rgba(255, 255, 255, 0.08)", active_background: "rgba(255, 255, 255, 0.12)", text: "rgba(244, 244, 245, 1)", focus_shadow: "0px -1px 0px 0px rgba(255, 255, 255, 0.06), 0px 0px 0px 1px rgba(255, 255, 255, 0.06), 0px 0px 0px 1px rgba(39, 39, 42, 1), 0px 0px 0px 2px rgba(24, 24, 27, 1), 0px 0px 0px 4px rgba(96, 165, 250, 0.8)" }
      transparent:
        size_tokens: { small: "txt-compact-small-plus gap-x-1.5 px-2 py-1", base: "txt-compact-small-plus gap-x-1.5 px-3 py-1.5", large: "txt-compact-medium-plus gap-x-1.5 px-4 py-2.5", xlarge: "txt-compact-large-plus gap-x-1.5 px-5 py-3.5" }
        light: { background: "transparent", hover_background: "rgba(244, 244, 245, 1)", active_background: "rgba(228, 228, 231, 1)", text: "rgba(24, 24, 27, 1)" }
        dark: { background: "transparent", hover_background: "rgba(255, 255, 255, 0.08)", active_background: "rgba(255, 255, 255, 0.12)", text: "rgba(244, 244, 245, 1)" }
      danger:
        size_tokens: { small: "txt-compact-small-plus gap-x-1.5 px-2 py-1", base: "txt-compact-small-plus gap-x-1.5 px-3 py-1.5", large: "txt-compact-medium-plus gap-x-1.5 px-4 py-2.5", xlarge: "txt-compact-large-plus gap-x-1.5 px-5 py-3.5" }
        light: { background: "rgba(225, 29, 72, 1)", hover_background: "rgba(190, 18, 60, 1)", active_background: "rgba(159, 18, 57, 1)", text: "rgba(255, 255, 255, 1)", focus_shadow: "0px 0.75px 0px 0px rgba(255, 255, 255, 0.2) inset, 0px 1px 2px 0px rgba(190, 18, 60, 0.4), 0px 0px 0px 1px rgba(190, 18, 60, 1), 0px 0px 0px 2px rgba(255, 255, 255, 1), 0px 0px 0px 4px rgba(59, 130, 246, 0.6)" }
        dark: { background: "rgba(159, 18, 57, 1)", hover_background: "rgba(190, 18, 60, 1)", active_background: "rgba(225, 29, 72, 1)", text: "rgba(255, 255, 255, 1)", focus_shadow: "0px -1px 0px 0px rgba(255, 255, 255, 0.16), 0px 0px 0px 1px rgba(255, 255, 255, 0.12), 0px 0px 0px 1px rgba(159, 18, 57, 1), 0px 0px 0px 2px rgba(24, 24, 27, 1), 0px 0px 0px 4px rgba(96, 165, 250, 0.8)" }
    shared_behaviors:
      typography: "txt-compact-small-plus base, rounded-md, inline-flex alignment"
      disabled: { background: "var(--bg-disabled)", border: "var(--border-base)", text: "var(--fg-disabled)", shadow: "var(--buttons-neutral)", hide_overlay: true }
  forms:
    input:
      base_classes: "caret-ui-fg-base bg-ui-bg-field hover:bg-ui-bg-field-hover shadow-borders-base text-ui-fg-base transition-fg rounded-md"
      focus_shadow_light: "0px 0px 0px 1px rgba(255, 255, 255, 1), 0px 0px 0px 3px rgba(59, 130, 246, 0.6)"
      focus_shadow_dark: "0px 0px 0px 1px rgba(24, 24, 27, 1), 0px 0px 0px 3px rgba(96, 165, 250, 0.8)"
      padding_tokens: { base: "px-2 py-1.5 h-8", small: "px-2 py-1 h-7" }
      state_colors:
        invalid: { shadow: "var(--borders-error)" }
        disabled: { background: "var(--bg-disabled)", text: "var(--fg-disabled)", placeholder: "var(--fg-disabled)" }
    textarea:
      base_classes: "txt-small min-h-[60px] px-2 py-1.5"
      inherits_input_styles: true
    select:
      trigger_classes: "bg-ui-bg-field shadow-buttons-neutral rounded-md transition-fg"
      padding_tokens: { base: "h-8 px-2 py-1.5", small: "h-7 px-2 py-1" }
      content_surface: "bg-ui-bg-component shadow-elevation-flyout rounded-lg"
      item_typography: "txt-compact-small"
    switch:
      track: { base_size: "h-[18px] w-[32px]", small_size: "h-[16px] w-[28px]", background: "var(--bg-switch-off)", hover_overlay: "bg-switch-off-hover-gradient", checked_background: "var(--bg-interactive)" }
      thumb: { base: "h-[14px] w-[14px]", small: "h-[12px] w-[12px]", color: "var(--fg-on-color)", shadow: "var(--details-switch-handle)" }
  layout:
    container_component:
      base: { padding: "px-6 py-4", radius: "8px", background: "var(--bg-base)", shadow: "var(--elevation-card-rest)" }
    docs_max_widths:
      sidebar: { xs: "calc(100% - 20px)", sm: "300px", md: "300px", lg: "221px", xl: "221px", xxl: "221px", xxxl: "221px" }
      main_content: { xs: "100%", sm: "100%", md: "100%", lg: "751px", xl: "1007px", xxl: "1263px", xxxl: "3567px" }
      inner_content: { xs: "100%", sm: "100%", md: "100%", lg: "550px", xl: "640px", xxl: "640px", xxxl: "640px" }
      wide_layout: { lg: "800px", xl: "1112px" }
      modal: { xs: "304px", sm: "624px", md: "752px", lg: "640px" }
      ai_assistant: "500px"
    widths:
      toc: "221px"
      sidebar_xs: "calc(100% - 20px)"
      ai_assistant: "500px"
    spacing_scale:
      px: "1px"
      0: "0px"
      0.125: "2px"
      0.25: "4px"
      0.4: "7px"
      0.5: "8px"
      0.75: "12px"
      1: "16px"
      1.5: "24px"
      2: "32px"
      2.5: "40px"
      3: "48px"
      4: "64px"
      5: "80px"
      6: "96px"
      7: "112px"
      8: "128px"
    line_height_default: "24px"
  breakpoints:
    xs: "568px"
    sm: "640px"
    md: "768px"
    lg: "1024px"
    xl: "1280px"
    xxl: "1536px"
    xxxl: "1800px"
    xxxxl: "3840px"
  borders:
    radius:
      xxs: "2px"
      xs: "4px"
      sm: "6px"
      default: "8px"
      md: "8px"
      lg: "12px"
      xl: "16px"
  shadows:
    docs_light:
      elevation_card_rest: "0px 0px 0px 1px rgba(0, 0, 0, 0.08), 0px 1px 2px -1px rgba(0, 0, 0, 0.08), 0px 2px 4px 0px rgba(0, 0, 0, 0.04)"
      elevation_card_hover: "0px 0px 0px 1px rgba(0, 0, 0, 0.08), 0px 1px 2px -1px rgba(0, 0, 0, 0.08), 0px 2px 8px 0px rgba(0, 0, 0, 0.10)"
      elevation_tooltip: "0px 0px 0px 1px rgba(0, 0, 0, 0.08), 0px 2px 4px 0px rgba(0, 0, 0, 0.08), 0px 4px 8px 0px rgba(0, 0, 0, 0.08)"
      elevation_flyout: "0px 0px 0px 1px rgba(0, 0, 0, 0.08), 0px 4px 8px 0px rgba(0, 0, 0, 0.08), 0px 8px 16px 0px rgba(0, 0, 0, 0.08)"
      elevation_modal: "0px 0px 0px 1px #FFF inset, 0px 0px 0px 1.5px rgba(228, 228, 231, 0.60) inset, 0px 0px 0px 1px rgba(0, 0, 0, 0.08), 0px 8px 16px 0px rgba(0, 0, 0, 0.08), 0px 16px 32px 0px rgba(0, 0, 0, 0.08)"
      elevation_code_block: "0px 0px 0px 1px #18181B inset, 0px 0px 0px 1.5px rgba(255, 255, 255, 0.20) inset"
      button_neutral: "0px 1px 2px 0px rgba(0, 0, 0, 0.12), 0px 0px 0px 1px rgba(0, 0, 0, 0.08)"
      button_neutral_focus: "0px 1px 2px 0px rgba(0, 0, 0, 0.12), 0px 0px 0px 1px rgba(0, 0, 0, 0.08), 0px 0px 0px 2px rgba(255, 255, 255, 1), 0px 0px 0px 4px rgba(59, 130, 246, 0.6)"
      button_danger: "0px 0.75px 0px 0px rgba(255, 255, 255, 0.2) inset, 0px 1px 2px 0px rgba(190, 18, 60, 0.4), 0px 0px 0px 1px rgba(190, 18, 60, 1)"
      button_danger_focus: "0px 0.75px 0px 0px rgba(255, 255, 255, 0.2) inset, 0px 1px 2px 0px rgba(190, 18, 60, 0.4), 0px 0px 0px 1px rgba(190, 18, 60, 1), 0px 0px 0px 2px rgba(255, 255, 255, 1), 0px 0px 0px 4px rgba(59, 130, 246, 0.6)"
      button_inverted: "0px 0.75px 0px 0px rgba(255, 255, 255, 0.2) inset, 0px 1px 2px 0px rgba(0, 0, 0, 0.4), 0px 0px 0px 1px rgba(24, 24, 27, 1)"
      button_inverted_focus: "0px 0.75px 0px 0px rgba(255, 255, 255, 0.2) inset, 0px 1px 2px 0px rgba(0, 0, 0, 0.4), 0px 0px 0px 1px rgba(24, 24, 27, 1), 0px 0px 0px 2px rgba(255, 255, 255, 1), 0px 0px 0px 4px rgba(59, 130, 246, 0.6)"
      borders_base: "0px 1px 2px 0px rgba(0, 0, 0, 0.12), 0px 0px 0px 1px rgba(0, 0, 0, 0.08)"
      borders_interactive_focus: "0px 1px 2px 0px rgba(30, 58, 138, 0.5), 0px 0px 0px 1px rgba(37, 99, 235, 1), 0px 0px 0px 2px rgba(255, 255, 255, 1), 0px 0px 0px 4px rgba(37, 99, 235, 0.6)"
      borders_interactive_active: "0px 0px 0px 4px rgba(37, 99, 235, 0.2), 0px 0px 0px 1px rgba(37, 99, 235, 1)"
    docs_dark:
      elevation_card_rest: "0px -1px 0px 0px rgba(255, 255, 255, 0.06), 0px 0px 0px 1px rgba(255, 255, 255, 0.06), 0px 0px 0px 1px #27272A, 0px 1px 2px 0px rgba(0, 0, 0, 0.32), 0px 2px 4px 0px rgba(0, 0, 0, 0.32)"
      elevation_card_hover: "0px -1px 0px 0px rgba(255, 255, 255, 0.06), 0px 0px 0px 1px rgba(255, 255, 255, 0.06), 0px 0px 0px 1px #27272A, 0px 1px 4px 0px rgba(0, 0, 0, 0.48), 0px 2px 8px 0px rgba(0, 0, 0, 0.48)"
      elevation_tooltip: "0px -1px 0px 0px rgba(255, 255, 255, 0.04), 0px 2px 4px 0px rgba(0, 0, 0, 0.32), 0px 0px 0px 1px rgba(255, 255, 255, 0.1), 0px 4px 8px 0px rgba(0, 0, 0, 0.32)"
      elevation_flyout: "0px -1px 0px 0px rgba(255, 255, 255, 0.04), 0px 0px 0px 1px rgba(255, 255, 255, 0.1), 0px 4px 8px 0px rgba(0, 0, 0, 0.32), 0px 8px 16px 0px rgba(0, 0, 0, 0.32)"
      elevation_modal: "0px 0px 0px 1px rgba(24, 24, 27, 1) inset, 0px 0px 0px 1.5px rgba(255, 255, 255, 0.06) inset, 0px -1px 0px 0px rgba(255, 255, 255, 0.04), 0px 0px 0px 1px rgba(255, 255, 255, 0.1), 0px 4px 8px 0px rgba(0, 0, 0, 0.32), 0px 8px 16px 0px rgba(0, 0, 0, 0.32)"
      elevation_code_block: "0px -1px 0px 0px rgba(255, 255, 255, 0.06), 0px 0px 0px 1px rgba(255, 255, 255, 0.06), 0px 0px 0px 1px #27272A, 0px 1px 2px 0px rgba(0, 0, 0, 0.32), 0px 2px 4px 0px rgba(0, 0, 0, 0.32)"
      button_neutral: "0px -1px 0px 0px rgba(255, 255, 255, 0.06), 0px 0px 0px 1px rgba(255, 255, 255, 0.06), 0px 0px 0px 1px rgba(39, 39, 42, 1), 0px 0px 1px 1.5px rgba(0, 0, 0, 0.24), 0px 2px 2px 0px rgba(0, 0, 0, 0.24)"
      button_neutral_focus: "0px -1px 0px 0px rgba(255, 255, 255, 0.06), 0px 0px 0px 1px rgba(255, 255, 255, 0.06), 0px 0px 0px 1px rgba(39, 39, 42, 1), 0px 0px 0px 2px rgba(24, 24, 27, 1), 0px 0px 0px 4px rgba(96, 165, 250, 0.8)"
      button_danger: "0px -1px 0px 0px rgba(255, 255, 255, 0.16), 0px 0px 0px 1px rgba(255, 255, 255, 0.12), 0px 0px 0px 1px rgba(159, 18, 57, 1), 0px 0px 1px 1.5px rgba(0, 0, 0, 0.24), 0px 2px 2px 0px rgba(0, 0, 0, 0.24)"
      button_danger_focus: "0px -1px 0px 0px rgba(255, 255, 255, 0.16), 0px 0px 0px 1px rgba(255, 255, 255, 0.12), 0px 0px 0px 1px rgba(159, 18, 57, 1), 0px 0px 0px 2px rgba(24, 24, 27, 1), 0px 0px 0px 4px rgba(96, 165, 250, 0.8)"
      button_inverted: "0px -1px 0px 0px rgba(255, 255, 255, 0.12), 0px 0px 0px 1px rgba(255, 255, 255, 0.1), 0px 0px 0px 1px rgba(82, 82, 91, 1), 0px 0px 1px 1.5px rgba(0, 0, 0, 0.24), 0px 2px 2px 0px rgba(0, 0, 0, 0.24)"
      button_inverted_focus: "0px -1px 0px 0px rgba(255, 255, 255, 0.12), 0px 0px 0px 1px rgba(255, 255, 255, 0.12), 0px 0px 0px 1px rgba(82, 82, 91, 1), 0px 0px 0px 2px rgba(24, 24, 27, 1), 0px 0px 0px 4px rgba(96, 165, 250, 0.8)"
      borders_base: "0px -1px 0px 0px rgba(255, 255, 255, 0.06), 0px 0px 0px 1px rgba(255, 255, 255, 0.06), 0px 0px 0px 1px rgba(39, 39, 42, 1), 0px 0px 1px 1.5px rgba(0, 0, 0, 0.24), 0px 2px 2px 0px rgba(0, 0, 0, 0.24)"
      borders_interactive_focus: "0px -1px 2px 0px rgba(219, 234, 254, 0.5), 0px 0px 0px 1px rgba(96, 165, 250, 1), 0px 0px 0px 2px rgba(24, 24, 27, 1), 0px 0px 0px 4px rgba(96, 165, 250, 0.8)"
      borders_interactive_active: "0px 0px 0px 1px rgba(96, 165, 250, 1), 0px 0px 0px 4px rgba(59, 130, 246, 0.25)"
  transitions:
    property_fg: "color, background-color, border-color, box-shadow, opacity"
    timing_function: "ease"
    animation_defaults: { fadeIn: "500ms", fadeOut: "500ms" }
  modes:
    dark_mode_selectors: ["class", "[data-theme="dark"]"]
