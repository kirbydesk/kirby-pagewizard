<template>
  <!-- an option of a content field as in the drawer: its icon or its text -->
  <span v-if="isIcon" class="k-button-icon"><svg aria-hidden="true" class="k-icon" viewBox="0 0 24 24" fill="currentColor" v-html="html"></svg></span>
  <span v-else class="k-button-text pw-size-label">{{ text }}</span>
</template>

<script>
import { hasIcon, iconHtml, optionText } from './option-display.js';

export default {
  props: {
    // level, size, align, textbackground, multiline, flourish, mode
    type: { type: String, required: true },
    value: { type: String, default: '' },
  },
  computed: {
    isIcon() {
      return hasIcon(this.type, this.value);
    },
    html() {
      return iconHtml(this.type, this.value);
    },
    text() {
      return optionText(this.type, this.value, (key, fallback) => this.$t(key, fallback));
    },
  },
};
</script>
