const DRAWER_SELECTOR = '.k-drawer.k-form-drawer';
const DRAWER_ACTIVE_SELECTOR = `${DRAWER_SELECTOR}[aria-current="true"]`;
const DRAWER_CLOSED_SELECTOR = `${DRAWER_SELECTOR}[aria-current="false"][data-block-id]`;
const SPACING_TAB_HIDDEN_CLASS = 'hide-spacing-tab';

export default {
  mounted() {
    // Claim drawer on mount (for new blocks that open immediately)
    setTimeout(() => {
      this.claimActiveDrawerForSpacing();
    }, 100);

    // Watch for toggle changes in block settings
    this.$watch(
      () => this.content.togglespacing,
      () => {
        this.setSpacingDrawerClass();
      }
    );

    // Listen for double-clicks on this block to claim the drawer
    if (this.$el) {
      this._handleDblClickSpacing = () => {
        setTimeout(() => {
          this.claimActiveDrawerForSpacing();
        }, 20);
      };
      this.$el.addEventListener('dblclick', this._handleDblClickSpacing);
    }

    // Watch for drawer state changes (e.g., when reopening)
    this.spacingDrawerObserver = new MutationObserver((mutations) => {
      const relevantChange = mutations.some(mutation => {
        if (mutation.type === 'attributes' && mutation.attributeName === 'aria-current') {
          const blockId = mutation.target.getAttribute('data-block-id');
          return blockId === this.id;
        }
        return false;
      });

      if (relevantChange) {
        this.setSpacingDrawerClass();
      }
    });

    this.spacingDrawerObserver.observe(document.body, {
      attributes: true,
      attributeFilter: ['aria-current'],
      subtree: true
    });
  },

  beforeDestroy() {
    if (this.spacingDrawerObserver) {
      this.spacingDrawerObserver.disconnect();
    }
    if (this.$el && this._handleDblClickSpacing) {
      this.$el.removeEventListener('dblclick', this._handleDblClickSpacing);
    }
  },

  methods: {
    claimActiveDrawerForSpacing() {
      // Clean up closed drawers
      const closedDrawers = document.querySelectorAll(DRAWER_CLOSED_SELECTOR);
      closedDrawers.forEach(drawer => drawer.removeAttribute('data-block-id'));

      // Claim the active drawer for this block
      const activeDrawer = document.querySelector(DRAWER_ACTIVE_SELECTOR);
      if (activeDrawer) {
        const isOff = this.content.togglespacing === false || this.content.togglespacing === 'false';

        // Set data-block-id and class state together in same frame to prevent flicker
        activeDrawer.setAttribute('data-block-id', this.id);

        if (isOff) {
          activeDrawer.classList.add(SPACING_TAB_HIDDEN_CLASS);
        } else {
          activeDrawer.classList.remove(SPACING_TAB_HIDDEN_CLASS);
        }
      }
    },

    setSpacingDrawerClass() {
      const drawer = document.querySelector(`${DRAWER_SELECTOR}[data-block-id="${this.id}"]`);

      if (drawer) {
        const isOff = this.content.togglespacing === false || this.content.togglespacing === 'false';
        drawer.classList.toggle(SPACING_TAB_HIDDEN_CLASS, isOff);
      }
    }
  }
};
