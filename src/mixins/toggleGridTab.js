export default {
  mounted() {
    this.setGridDrawerClass();

    this.$watch(
      () => this.content.togglegrid,
      () => {
        this.setGridDrawerClass();
      }
    );

    this.gridDrawerObserver = new MutationObserver(() => {
      this.setGridDrawerClass();
    });
    this.gridDrawerObserver.observe(document.body, { childList: true, subtree: true });
  },

  beforeDestroy() {
    if (this.gridDrawerObserver) {
      this.gridDrawerObserver.disconnect();
    }
  },

  methods: {
    setGridDrawerClass() {
      console.log('toggleGridTab.js: this.id', this.id);
      // Try to find the drawer for this block by data-block-id
      let drawer = document.querySelector('.k-drawer.k-form-drawer[data-block-id="' + this.id + '"]');
      console.log('toggleGridTab.js: drawer before', drawer);
      // If not found, try to set the attribute on the active drawer (only needed the first time)
      if (!drawer) {
        const activeDrawer = document.querySelector('.k-drawer.k-form-drawer[aria-current="true"]');
        if (activeDrawer) {
          activeDrawer.setAttribute('data-block-id', this.id);
          drawer = activeDrawer;
        }
      }
      console.log('toggleGridTab.js: drawer after', drawer);
      if (drawer) {
        const isOff = this.toggleGrid === false || this.toggleGrid === 'false';
        console.log('toggleGridTab.js: toggleGrid value', this.toggleGrid, 'isOff:', isOff);
        drawer.classList.toggle('hide-grid-tab', isOff);
        console.log('toggleGridTab.js: hide-grid-tab gesetzt:', drawer.classList.contains('hide-grid-tab'), drawer);
      } else {
        console.warn('toggleGridTab.js: Kein Drawer gefunden für id', this.id);
      }
    }
  }
};