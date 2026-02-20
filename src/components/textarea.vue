<template>
  <div class="pwtext" :data-align="align">
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
    align: { type: String, default: 'left' }
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
	margin-bottom: var(--spacing-2);
	color: var(--pw-color-text, inherit);

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