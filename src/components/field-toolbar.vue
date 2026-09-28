<template>
  <!-- the dropdown buttons of a content field (level, size, alignment, text
       marking, multiline, flourish, editor mode) as in the block drawer;
       used by the fields themselves and by the Project Wizard's start values -->
  <div class="k-button-group pw-field-toolbar">
    <span v-for="item in items" :key="item.key" class="pw-field-toolbar-item">
      <button
        :data-has-icon="hasIcon(item) ? 'true' : 'false'"
        :data-has-text="hasIcon(item) ? 'false' : 'true'"
        :aria-label="$t('pw.toolbar.' + item.key)"
        :title="$t('pw.toolbar.' + item.key)"
        data-size="xs"
        data-variant="filled"
        type="button"
        class="input-focus k-button"
        @click.stop="toggle(item.key)"
      >
        <span v-if="hasIcon(item)" class="k-button-icon"><svg aria-hidden="true" class="k-icon" viewBox="0 0 24 24" fill="currentColor" v-html="icon(item.key, item.value)"></svg></span>
        <span v-else class="k-button-text pw-size-label">{{ text(item.key, item.value) }}</span>
        <!-- it opens a menu: Kirby's dropdown arrow (as k-button with "dropdown") -->
        <span class="k-button-arrow"><k-icon type="angle-dropdown" /></span>
      </button>
      <dialog v-if="open === item.key" class="k-dropdown-content pw-dropdown" data-theme="dark" open>
        <div class="k-navigate">
          <button
            v-for="option in item.options"
            :key="option"
            type="button"
            class="k-button k-dropdown-item"
            :data-has-icon="hasIcon(item) ? 'true' : 'false'"
            :data-has-text="hasIcon(item) ? 'false' : 'true'"
            :aria-current="option === item.value ? 'true' : undefined"
            @click.stop="choose(item.key, option)"
          >
            <span v-if="hasIcon(item)" class="k-button-icon"><svg class="k-icon" viewBox="0 0 24 24" fill="currentColor" v-html="icon(item.key, option)"></svg></span>
            <span v-else class="k-button-text pw-size-label">{{ text(item.key, option) }}</span>
          </button>
        </div>
      </dialog>
    </span>
  </div>
</template>

<script>
// own icons (text marking, multiline, flourish) per value
const PATHS = {
  textbackground: {
    disabled: '<path d="M9 4.9967V11.2694H7V4.9967H5V13.9967H19V4.9967H9ZM20 15.9967H4V17.9967H20V15.9967ZM3 13.9967V3.9967C3 3.44442 3.44772 2.9967 4 2.9967H20C20.5523 2.9967 21 3.44442 21 3.9967V13.9967H22V18.9967C22 19.549 21.5523 19.9967 21 19.9967H13V22.9967H11V19.9967H3C2.44772 19.9967 2 19.549 2 18.9967V13.9967H3Z"/>',
    enabled: '<path d="M20 15.9967H4V17.9967H20V15.9967ZM3 13.9967V3.9967C3 3.44442 3.44772 2.9967 4 2.9967H7V11.2694H9V2.9967H20C20.5523 2.9967 21 3.44442 21 3.9967V13.9967H22V18.9967C22 19.549 21.5523 19.9967 21 19.9967H13V22.9967H11V19.9967H3C2.44772 19.9967 2 19.549 2 18.9967V13.9967H3Z"/>',
  },
  multiline: {
    disabled: '<path d="M5 19H19V5H5V19ZM3 4C3 3.44772 3.44772 3 4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4ZM10 8V11H14V8L18 12L14 16V13H10V16L6 12L10 8Z"/>',
    enabled: '<path d="M5 19H19V5H5V19ZM3 4C3 3.44772 3.44772 3 4 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4ZM8 10L12 6L16 10H13V14H16L12 18L8 14H11V10L8 10Z"/>',
  },
  flourish: {
    disabled: '<path d="M5.55397 22H3.3999L10.9999 3H12.9999L20.5999 22H18.4458L16.0458 16H7.95397L5.55397 22ZM8.75397 14H15.2458L11.9999 5.88517L8.75397 14Z"/>',
    enabled: '<path d="M15.2459 14H8.75407L7.15407 18H5L11 3H13L19 18H16.8459L15.2459 14ZM14.4459 12L12 5.88516L9.55407 12H14.4459ZM3 20H21V22H3V20Z"/>',
  },
};

export default {
  props: {
    // [{ key: 'level' | 'size' | 'align' | 'textbackground' | 'multiline' |
    //    'flourish' | 'mode', value, options: [...] }] in the order shown
    items: { type: Array, default: () => [] },
  },
  emits: ['input'],
  data() {
    return {
      // the open dropdown (one at a time)
      open: null,
    };
  },
  methods: {
    // size and editor mode show their text, the others an icon
    hasIcon(item) {
      return !['size', 'mode'].includes(item.key) && !(item.key === 'align' && !item.value);
    },
    icon(key, value) {
      if (PATHS[key]) return PATHS[key][value] || PATHS[key].disabled;
      // Kirby's sprite: text-left …, h1 …; "div" (no heading element) its own
      const name = key === 'align' ? 'text-' + value : (value === 'div' ? 'pw-level-div' : value);
      return '<use href="#icon-' + name + '"></use>';
    },
    text(key, value) {
      if (key === 'mode') return this.$t('pw.field.text-' + value, value);
      if (key === 'align') return '···';
      return this.$t('pw.option.' + value, value);
    },
    toggle(key) {
      this.open = this.open === key ? null : key;
    },
    choose(key, value) {
      this.open = null;
      this.$emit('input', { key, value });
    },
    onClickOutside(event) {
      if (!this.$el.contains(event.target)) this.open = null;
    },
    onEscape(event) {
      if (event.key === 'Escape' && this.open) {
        event.stopPropagation();
        event.preventDefault();
        this.open = null;
      }
    },
  },
  mounted() {
    document.addEventListener('click', this.onClickOutside, true);
    document.addEventListener('keydown', this.onEscape);
  },
  beforeDestroy() {
    document.removeEventListener('click', this.onClickOutside, true);
    document.removeEventListener('keydown', this.onEscape);
  },
};
</script>

<style>
.pw-field-toolbar-item {
  position: relative;
}
/* menu entries: full width and left aligned as in Kirby's menus, so the
   icons line up and the current one's check mark sits on the right */
.pw-field-toolbar .pw-dropdown .k-dropdown-item {
  --button-width: 100%;
  aspect-ratio: auto;
  justify-content: flex-start;
  padding-inline: var(--spacing-2);
}
/* the dropdown arrow close to the icon / text */
.pw-field-toolbar-item > .k-button {
  gap: var(--spacing-1);
}
/* icon buttons are square in Kirby; with the dropdown arrow they need room */
.pw-field-toolbar-item > .k-button:not([data-has-text="true"]) {
  --button-padding: var(--spacing-1);
  padding-inline: var(--spacing-2) var(--spacing-1);
  aspect-ratio: auto;
}
</style>
