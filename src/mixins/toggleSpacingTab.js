export default {
  mounted() {
    this.setSpacingDrawerClass();

    this.$watch(
      () => this.content.togglespacing,
      () => {
        this.setSpacingDrawerClass();
      }
    );

    this.spacingDrawerObserver = new MutationObserver(() => {
      this.setSpacingDrawerClass();
    });
    this.spacingDrawerObserver.observe(document.body, { childList: true, subtree: true });
  },

  beforeDestroy() {
    if (this.spacingDrawerObserver) {
      this.spacingDrawerObserver.disconnect();
    }
  },

  methods: {
    setSpacingDrawerClass() {
      const drawers = document.querySelectorAll('.k-drawer.k-form-drawer');
      drawers.forEach(drawer => {
        drawer.classList.toggle('hide-spacing-tab', this.content.togglespacing === false);
      });
    }
  }
};
