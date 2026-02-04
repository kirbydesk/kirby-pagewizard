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
      const drawers = document.querySelectorAll('.k-drawer.k-form-drawer');
      drawers.forEach(drawer => {
        drawer.classList.toggle('hide-grid-tab', this.content.togglegrid === false);
      });
    }
  }
};