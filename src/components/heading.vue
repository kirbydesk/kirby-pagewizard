<template>
  <div class="pwHeading" :data-level="level">
    <div v-if="value" v-html="value"></div>
    <div v-else class="placeholder">
      {{ $t('pw.field.heading.placeholder') }}
    </div>
  </div>
</template>
<script>
export default {
  props: {
    value: String,
		level: String
  }
}
</script>
<style scoped>
div.pwHeading {
	margin-bottom: var(--spacing-2);
	line-height: var(--text-line-height);

	&[data-level="h1"]{
		font-size: var(--text-2xl);
		font-weight: var(--font-normal);
	}
	&[data-level="h2"]{
		font-size: var(--text-xl);
		font-weight: var(--font-semi);
	}
	&[data-level="h3"]{
		font-size: var(--text-lg);
		font-weight: var(--font-bold);
	}
	&[data-level="h4"]{
		font-size: var(--text-md);
		font-weight: var(--font-bold);
	}
}
</style>