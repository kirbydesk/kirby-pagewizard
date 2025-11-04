<template>
  <div class="pwText">
    <div v-if="value" v-html="nl2br(value)"></div>
    <div v-else class="placeholder">
      {{ $t('pw.field.text-textarea.placeholder') }}
    </div>
  </div>
</template>
<script>
export default {
  props: {
    value: String
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
div.pwText {
  font-size: var(--text-sm);
	line-height: var(--text-line-height);
	margin-bottom: var(--spacing-2);
}
</style>