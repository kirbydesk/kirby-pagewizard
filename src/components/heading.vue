<template>
	<div class="pwHeading" :data-align="align" :data-size="size">
    <div v-if="text">
      <span v-if="textbackground === 'enabled'" data-textbackground v-html="text"></span>
      <span v-else v-html="text"></span>
    </div>
    <div v-else class="placeholder">
      {{ $t('pw.field.heading.placeholder') }}
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
    alignDefault:          { type: String, default: null },
    sizeDefault:           { type: String, default: null },
    textbackgroundDefault: { type: String, default: null }
  },
  computed: {
    parsedData() {
      const val = this.content?.heading || this.value;
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
    },
    size() {
      const { size = this.sizeDefault } = this.parsedData;
      return size;
    },
    textbackground() {
      const { textbackground = this.textbackgroundDefault } = this.parsedData;
      return textbackground;
    }
  }
}
</script>
<style scoped>
div.pwHeading {
	color: var(--pw-color-heading, inherit);
	line-height: 1.3;

	[data-textbackground] {
		color: var(--pw-color-heading-marked-text);
		background-color: var(--pw-color-heading-marked-background);
		box-decoration-break: clone;
		-webkit-box-decoration-break: clone;
		padding: 0.1em 0.3em;
		border-radius: 0.15em;
	}

	&[data-size="xs"]  { font-size: var(--text-md); font-weight: var(--font-bold)}
	&[data-size="sm"]  { font-size: var(--text-lg); font-weight: var(--font-bold); }
	&[data-size="md"]  { font-size: var(--text-xl); font-weight: var(--font-semi)}
	&[data-size="lg"]  { font-size: var(--text-2xl); }
	&[data-size="xl"]  { font-size: var(--text-3xl); }
	&[data-size="2xl"] { font-size: var(--text-4xl); }
	&[data-size="3xl"] { font-size: var(--text-5xl); }
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
