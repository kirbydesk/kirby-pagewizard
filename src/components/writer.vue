<template>
  <div class="pwtext" :data-align="align" :data-size="size">
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
    align: { type: String, default: 'left' },
    size:  { type: String, default: null }
  }
}
</script>
<style scoped>
div.pwtext {
  font-size: var(--text-sm);
	color: var(--pw-color-text, inherit);
	line-height: var(--text-line-height);

	&[data-size="lg"]  { font-size: var(--text-lg);  line-height: 1.3; }
	&[data-size="xl"]  { font-size: var(--text-xl);  line-height: 1.3; }
	&[data-size="2xl"] { font-size: var(--text-2xl); line-height: 1.3; }
	&[data-size="3xl"] { font-size: var(--text-3xl); line-height: 1.3; }

	&[data-align="left"] { text-align: left; }
	&[data-align="center"] { text-align: center; }
	&[data-align="right"] { text-align: right; }

	:deep(h1) {
		font-size: var(--text-xl);
		font-weight: var(--font-normal);
		line-height: 1.3;
	}
	:deep(h2) {
		font-size: var(--text-lg);
		font-weight: var(--font-semi);
		line-height: 1.3;
	}
	:deep(h3) {
		font-size: var(--text-md);
		font-weight: var(--font-bold);
		line-height: 1.3;
	}
	:deep(h4) {
		font-size: var(--text-sm);
		font-weight: var(--font-bold);
		line-height: 1.3;
	}
	:deep(ul) {
		list-style-type: disc;
		padding: var(--spacing-2) var(--spacing-6);
	}
	:deep(ol) {
		list-style-type: decimal;
		padding: var(--spacing-2) var(--spacing-6);
	}
	:deep(a) {
		text-decoration: underline;
	}
}
</style>