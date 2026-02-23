<template>
  <div class="pwTagline" :data-align="align">
    <div v-if="text" v-html="text"></div>
    <div v-else class="placeholder">
      {{ $t('pw.field.tagline.placeholder') }}
    </div>
  </div>
</template>
<script>
export default {
  props: {
    value: String,
    content: {
      type: Object,
      default: () => ({})
    },
    alignDefault: { type: String, default: 'left' }
  },
  computed: {
    parsedData() {
      const val = this.content?.tagline || this.value;
      if (!val) return { text: '', align: this.alignDefault };
      try {
        return typeof val === 'string' ? JSON.parse(val) : val;
      } catch(e) {
        return { text: val, align: this.alignDefault };
      }
    },
    text() {
      const { text = '' } = this.parsedData;
      return text;
    },
    align() {
      const { align = this.alignDefault } = this.parsedData;
      return align;
    }
  }
}
</script>
<style scoped>
div.pwTagline {
  font-size: var(--text-sm);
	line-height: var(--text-line-height);
	text-transform: uppercase;
	margin-bottom: var(--spacing-1);
	color: var(--pw-color-tagline, inherit);

	&[data-align="left"] {
    text-align: left;
  }
  &[data-align="center"] {
    text-align: center;
  }
  &[data-align="right"] {
    text-align: right;
  }
}
</style>