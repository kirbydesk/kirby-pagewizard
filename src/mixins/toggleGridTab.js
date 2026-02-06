const DRAWER_SELECTOR = '.k-drawer.k-form-drawer';
const DRAWER_ACTIVE_SELECTOR = `${DRAWER_SELECTOR}[aria-current="true"]`;
const DRAWER_CLOSED_SELECTOR = `${DRAWER_SELECTOR}[aria-current="false"][data-block-id]`;
const GRID_TAB_HIDDEN_CLASS = 'hide-grid-tab';

export default {
  mounted() {
    // Watch for toggle changes in block settings
    this.$watch(
      () => this.content.togglegrid,
      () => {
        this.setGridDrawerClass();
      }
    );

    // Listen for double-clicks on this block to claim the drawer
    if (this.$el) {
      this._handleDblClick = () => {
        requestAnimationFrame(() => {
          requestAnimationFrame(() => {
            this.claimActiveDrawerForGrid();
          });
        });
      };
      this.$el.addEventListener('dblclick', this._handleDblClick);
    }

    // Watch for drawer state changes (e.g., when reopening)
    this.gridDrawerObserver = new MutationObserver((mutations) => {
      const relevantChange = mutations.some(mutation => {
        if (mutation.type === 'attributes' && mutation.attributeName === 'aria-current') {
          const blockId = mutation.target.getAttribute('data-block-id');
          return blockId === this.id;
        }
        return false;
      });

      if (relevantChange) {
        this.setGridDrawerClass();
      }
    });

    this.gridDrawerObserver.observe(document.body, {
      attributes: true,
      attributeFilter: ['aria-current'],
      subtree: true
    });
  },

  beforeDestroy() {
    if (this.gridDrawerObserver) {
      this.gridDrawerObserver.disconnect();
    }
    if (this.$el && this._handleDblClick) {
      this.$el.removeEventListener('dblclick', this._handleDblClick);
    }
  },

  methods: {
    claimActiveDrawerForGrid() {
      // Clean up closed drawers
      const closedDrawers = document.querySelectorAll(DRAWER_CLOSED_SELECTOR);
      closedDrawers.forEach(drawer => drawer.removeAttribute('data-block-id'));

      // Claim the active drawer for this block
      const activeDrawer = document.querySelector(DRAWER_ACTIVE_SELECTOR);
      if (activeDrawer) {
        const isOff = this.content.togglegrid === false || this.content.togglegrid === 'false';

        // Set data-block-id and class state together in same frame to prevent flicker
        activeDrawer.setAttribute('data-block-id', this.id);

        if (isOff) {
          activeDrawer.classList.add(GRID_TAB_HIDDEN_CLASS);
        } else {
          activeDrawer.classList.remove(GRID_TAB_HIDDEN_CLASS);
        }
      }
    },

    setGridDrawerClass() {
      const drawer = document.querySelector(`${DRAWER_SELECTOR}[data-block-id="${this.id}"]`);

      if (drawer) {
        const isOff = this.content.togglegrid === false || this.content.togglegrid === 'false';
        drawer.classList.toggle(GRID_TAB_HIDDEN_CLASS, isOff);
      }
    }
  }
};