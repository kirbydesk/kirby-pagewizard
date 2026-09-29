<template>
  <!-- the dropdown buttons of a content field (level, size, alignment, text
       marking, multiline, flourish, editor mode) as in the block drawer;
       used by the fields themselves and by the Project Wizard's start values -->
  <div class="k-button-group pw-field-toolbar">
    <span v-for="item in items" :key="item.key" class="pw-field-toolbar-item">
      <button
        :data-has-icon="isIcon(item.key, item.value) ? 'true' : 'false'"
        :data-has-text="isIcon(item.key, item.value) ? 'false' : 'true'"
        :aria-label="$t('pw.toolbar.' + item.key)"
        :title="$t('pw.toolbar.' + item.key)"
        data-size="xs"
        data-variant="filled"
        type="button"
        class="input-focus k-button"
        @click.stop="toggle(item.key)"
      >
        <pw-option-icon :type="item.key" :value="item.value" :options="item.options" />
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
            :data-has-icon="isIcon(item.key, option) ? 'true' : 'false'"
            :data-has-text="isIcon(item.key, option) ? 'false' : 'true'"
            :aria-current="option === item.value ? 'true' : undefined"
            @click.stop="choose(item.key, option)"
          >
            <pw-option-icon :type="item.key" :value="option" :options="item.options" />
          </button>
        </div>
      </dialog>
    </span>
  </div>
</template>

<script>
import { hasIcon } from './option-display.js';
import pwOptionIcon from './option-icon.vue';

export default {
  components: { pwOptionIcon },
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
    isIcon(key, value) {
      return hasIcon(key, value);
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
