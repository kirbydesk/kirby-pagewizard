const DRAWER_SELECTOR = '.k-drawer.k-form-drawer';
const DRAWER_ACTIVE_SELECTOR = `${DRAWER_SELECTOR}[aria-current="true"]`;
const DRAWER_CLOSED_SELECTOR = `${DRAWER_SELECTOR}[aria-current="false"][data-block-id]`;
const THEME_TAB_HIDDEN_CLASS = 'hide-theme-tab';

export default {
  mounted() {
    // Claim drawer on mount (for new blocks that open immediately)
    setTimeout(() => {
      this.claimActiveDrawerForTheme();
    }, 100);

    // Watch for toggle changes in block settings
    this.$watch(
      () => this.content.toggletheme,
      () => {
        this.setThemeDrawerClass();
      }
    );

    // Listen for double-clicks on this block to claim the drawer
    if (this.$el) {
      this._handleDblClickTheme = () => {
        setTimeout(() => {
          this.claimActiveDrawerForTheme();
        }, 20);
      };
      this.$el.addEventListener('dblclick', this._handleDblClickTheme);
    }

    // Watch for drawer state changes (e.g., when reopening)
    this.themeDrawerObserver = new MutationObserver((mutations) => {
      const relevantChange = mutations.some(mutation => {
        if (mutation.type === 'attributes' && mutation.attributeName === 'aria-current') {
          const blockId = mutation.target.getAttribute('data-block-id');
          return blockId === this.id;
        }
        return false;
      });

      if (relevantChange) {
        this.setThemeDrawerClass();
      }
    });

    this.themeDrawerObserver.observe(document.body, {
      attributes: true,
      attributeFilter: ['aria-current'],
      subtree: true
    });
  },

  beforeDestroy() {
    if (this.themeDrawerObserver) {
      this.themeDrawerObserver.disconnect();
    }
    if (this.$el && this._handleDblClickTheme) {
      this.$el.removeEventListener('dblclick', this._handleDblClickTheme);
    }
  },

  methods: {
    claimActiveDrawerForTheme() {
      // Clean up closed drawers
      const closedDrawers = document.querySelectorAll(DRAWER_CLOSED_SELECTOR);
      closedDrawers.forEach(drawer => drawer.removeAttribute('data-block-id'));

      // Claim the active drawer for this block
      const activeDrawer = document.querySelector(DRAWER_ACTIVE_SELECTOR);
      if (activeDrawer) {
        const isOff = this.content.toggletheme === false || this.content.toggletheme === 'false';

        // Set data-block-id and class state together in same frame to prevent flicker
        activeDrawer.setAttribute('data-block-id', this.id);

        if (isOff) {
          activeDrawer.classList.add(THEME_TAB_HIDDEN_CLASS);
        } else {
          activeDrawer.classList.remove(THEME_TAB_HIDDEN_CLASS);
        }
      }
    },

    setThemeDrawerClass() {
      const drawer = document.querySelector(`${DRAWER_SELECTOR}[data-block-id="${this.id}"]`);

      if (drawer) {
        const isOff = this.content.toggletheme === false || this.content.toggletheme === 'false';
        drawer.classList.toggle(THEME_TAB_HIDDEN_CLASS, isOff);
      }
    }
  }
};
