<template>
  <div class="pwtext" :data-align="align">
    <div v-if="value" v-html="value"></div>
    <div v-else class="placeholder">
      {{ $t('pw.field.text-writer.placeholder') }}
    </div>
  </div>
</template>
<script>
export default {
  props: {
    value: String,
    align: { type: String, default: 'left' }
  }
}
</script>
<style scoped>
div.pwtext {
  font-size: var(--text-sm);

	&[data-align="left"] { text-align: left; }
	&[data-align="center"] { text-align: center; }
	&[data-align="right"] { text-align: right; }

	:deep(h1) {
		font-size: var(--text-2xl);
		font-weight: var(--font-normal);
		margin-bottom: var(--spacing-3);
	}
	:deep(h2) {
		font-size: var(--text-xl);
		font-weight: var(--font-semi);
		margin-bottom: var(--spacing-3);
	}
	:deep(h3) {
		font-size: var(--text-lg);
		font-weight: var(--font-bold);
		margin-bottom: var(--spacing-3);
	}
	:deep(h4) {
		font-size: var(--text-md);
		font-weight: var(--font-bold);
		margin-bottom: var(--spacing-3);
	}
	:deep(p) {
		line-height: var(--text-line-height);
	}
	:deep(ul) {
		list-style-type: disc;
		padding: var(--spacing-2) var(--spacing-6) var(--spacing-4);
	}
	:deep(ol) {
		list-style-type: decimal;
		padding: var(--spacing-2) var(--spacing-6) var(--spacing-4);
	}
	:deep(li) {
		line-height: var(--text-line-height);
	}
	:deep(a) {
		color: var(--link-color, #0070f3);
		text-decoration: underline;
	}
}
</style>