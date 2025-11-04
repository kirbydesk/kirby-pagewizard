<template>
  <div class="pwQuote">
    <div v-if="quote" class="quote" v-html="quote"></div>
    <div v-else class="quote placeholder">
      {{ $t('pw.field.text-quote.placeholder') }}
    </div>
		<div v-if="author" class="author" v-html="author"></div>
    <div v-else class="author placeholder">
      {{ $t('pw.field.author.placeholder') }}
    </div>
	</div>
</template>
<script>
export default {
  props: {
    quote: String,
		author: String
  }
}
</script>
<style scoped>
div.pwQuote {
	div.quote {
		font-size: var(--text-3xl);
		line-height: var(--text-line-height);
	}
	div.author {
		opacity: 0.8;
		margin: var(--spacing-2) 0;
		font-style: italic;
	}
}
</style>