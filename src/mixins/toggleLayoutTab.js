export default {
  mounted() {
    this.setDrawerClass();

    this.$watch(
      () => this.content.togglelayout,
      () => {
        this.setDrawerClass();
      }
    );

    this.drawerObserver = new MutationObserver(() => {
      this.setDrawerClass();
    });
    this.drawerObserver.observe(document.body, { childList: true, subtree: true });
  },

  beforeDestroy() {
    if (this.drawerObserver) {
      this.drawerObserver.disconnect();
    }
  },

  methods: {
    setDrawerClass() {
      const drawers = document.querySelectorAll('.k-drawer.k-form-drawer');
      drawers.forEach(drawer => {
        drawer.classList.toggle('hide-layout-tab', this.content.togglelayout === false);
      });
    }
  }
};