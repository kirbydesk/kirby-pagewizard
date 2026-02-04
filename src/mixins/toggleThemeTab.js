export default {
  mounted() {
    this.setThemeDrawerClass();

    this.$watch(
      () => this.content.toggletheme,
      () => {
        this.setThemeDrawerClass();
      }
    );

    this.themeDrawerObserver = new MutationObserver(() => {
      this.setThemeDrawerClass();
    });
    this.themeDrawerObserver.observe(document.body, { childList: true, subtree: true });
  },

  beforeDestroy() {
    if (this.themeDrawerObserver) {
      this.themeDrawerObserver.disconnect();
    }
  },

  methods: {
    setThemeDrawerClass() {
      const drawers = document.querySelectorAll('.k-drawer.k-form-drawer');
      drawers.forEach(drawer => {
        drawer.classList.toggle('hide-theme-tab', this.content.toggletheme === false);
      });
    }
  }
};
