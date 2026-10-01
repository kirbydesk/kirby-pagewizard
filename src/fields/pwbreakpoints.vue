<template>
  <!-- a heading over values per screen size (columns, grid, logos per row)
       with the sizes as pills: only the rows of the chosen one show – as
       in the Project Wizard; nothing is stored. It starts with the size the
       block previews show (the device above the blocks). -->
  <div :class="['k-headline-field', 'pw-breakpoints-field', $attrs.class]" :style="$attrs.style">
    <div class="pw-breakpoints-head">
      <k-headline class="h2">{{ label }}</k-headline>
      <span class="pw-breakpoints-pills" role="group">
        <button
          v-for="b in sizes"
          :key="b"
          type="button"
          :aria-pressed="bp === b ? 'true' : 'false'"
          @click="choose(b)"
        >{{ b.toUpperCase() }}</button>
      </span>
    </div>
    <footer v-if="shownHelp" class="k-field-footer">
      <k-text class="k-help k-field-help" :html="shownHelp" />
    </footer>
  </div>
</template>

<script>
// the previews' device (the Project Wizard marks it on <html>) → a size
const FROM_DEVICE = { xl: 'xl', lg: 'lg', md: 'md', sm: 'sm', default: 'sm' };
const deviceSize = () => FROM_DEVICE[document.documentElement.dataset.pwDevice] || 'xl';

export default {
  inheritAttrs: false,
  props: {
    label: String,
    help: String,
    // which rows: columns (columnssm …), grid (gridsize…/gridoffset…), logos
    // (logossm …), distribution (distributionsm …)
    group: { type: String, default: 'columns' },
    // the help of each size: shown for the chosen one
    sizeHelps: { type: Object, default: () => ({}) },
    // the heading and its rows gone while a field has this value
    // (e.g. { itemstyle: 'connected' })
    unless: { type: Object, default: null },
  },
  data() {
    return { sizes: ['sm', 'md', 'lg', 'xl'], bp: deviceSize() };
  },
  computed: {
    shownHelp() {
      return this.sizeHelps[this.bp] || this.help;
    },
    // the form's values: of the fieldset around the field
    formValues() {
      let vm = this.$parent;
      while (vm && vm.$options.name !== 'k-fieldset') vm = vm.$parent;
      return (vm && vm.value) || {};
    },
    off() {
      if (!this.unless) return false;
      return Object.keys(this.unless).some((key) => this.formValues[key.toLowerCase()] === this.unless[key]);
    },
  },
  watch: {
    off() {
      this.mark();
    },
  },
  mounted() {
    this.mark();
    // (the device changed above the blocks: follow it)
    this._observer = new MutationObserver(() => this.choose(deviceSize()));
    this._observer.observe(document.documentElement, { attributes: true, attributeFilter: ['data-pw-device'] });
  },
  beforeDestroy() {
    if (this._observer) this._observer.disconnect();
    const scope = this.scope();
    if (scope) scope.removeAttribute('data-pw-bp-' + this.group);
  },
  methods: {
    // the rows shown: set on the drawer (or the form) around the field
    scope() {
      return this.$el.closest('.k-drawer') || this.$el.closest('.k-fieldset');
    },
    mark() {
      const scope = this.scope();
      // (gone: none of the sizes' rows, the heading's column hidden too)
      if (scope) scope.setAttribute('data-pw-bp-' + this.group, this.off ? 'off' : this.bp);
      const column = this.$el.closest('.k-column');
      if (column) column.style.display = this.off ? 'none' : '';
    },
    choose(b) {
      this.bp = b;
      this.mark();
    },
  },
};
</script>

<style>
.pw-breakpoints-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: var(--spacing-3);
}
/* the pills: as the Project Wizard's switches */
.pw-breakpoints-pills {
  display: inline-flex;
  gap: 1px;
  border-radius: var(--rounded);
  background: var(--color-border);
  overflow: hidden;
}
.pw-breakpoints-pills button {
  height: var(--height-xs, 1.5rem);
  padding-inline: var(--spacing-2);
  font-size: var(--text-xs);
  color: var(--color-text);
  background: light-dark(var(--color-white), var(--color-gray-850));
}
.pw-breakpoints-pills button:hover {
  background: var(--color-blue-600);
  color: var(--color-white);
}
.pw-breakpoints-pills button[aria-pressed="true"] {
  background: light-dark(var(--color-black), var(--color-gray-950));
  color: var(--color-white);
  font-weight: var(--font-semi);
}
</style>
