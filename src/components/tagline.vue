<template>
  <div class="pwTagline">
    <div v-if="value" v-html="value"></div>
    <div v-else class="placeholder">
      {{ $t('pw.field.tagline.placeholder') }}
    </div>
  </div>
</template>
<script>
export default {
  props: {
    value: String
  }
}
</script>
<style scoped>
div.pwTagline {
  font-size: var(--text-sm);
	line-height: var(--text-line-height);
	margin-bottom: var(--spacing-1);
}
</style>