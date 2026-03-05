<template>
  <div class="pwtext" :data-align="align" :data-size="size">
    <div v-if="text" v-html="nl2br(text)"></div>
    <div v-else class="placeholder">
      {{ $t('pw.field.text-textarea.placeholder') }}
    </div>
  </div>
</template>
<script>
export default {
  props: {
    value: String,
    align: { type: String, default: 'left' },
    size:  { type: String, default: null }
  },
  computed: {
    text() {
      return this.value || '';
    }
  },
  methods: {
    nl2br(text) {
      if (!text) return '';
      return text.replace(/\n/g, '<br>');
    }
  }
}
</script>
<style scoped>
div.pwtext {
  font-size: var(--text-sm);
	line-height: var(--text-line-height);
	color: var(--pw-color-text, inherit);

	&[data-size="lg"]  { font-size: var(--text-lg);  line-height: 1.3; }
	&[data-size="xl"]  { font-size: var(--text-xl);  line-height: 1.3; }
	&[data-size="2xl"] { font-size: var(--text-2xl); line-height: 1.3; }
	&[data-size="3xl"] { font-size: var(--text-3xl); line-height: 1.3; }
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