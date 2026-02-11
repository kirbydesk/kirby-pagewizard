<template>
  <div class="pwquote">
    <div v-if="quoteText" class="quote" :data-align="quoteAlign" v-html="nl2br(quoteText)"></div>
    <div v-else class="quote placeholder">
      {{ $t('pw.field.text-quote.placeholder') }}
    </div>
		<div v-if="authorText" class="author" :data-align="authorAlign">{{ authorText }}</div>
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
  },
	computed: {
    parsedQuoteData() {
      const val = this.quote;
      if (!val) return { text: '', align: 'left' };
      try {
        return typeof val === 'string' ? JSON.parse(val) : val;
      } catch(e) {
        return { text: val, align: 'left' };
      }
    },
    parsedAuthorData() {
      const val = this.author;
      if (!val) return { text: '' };
      try {
        return typeof val === 'string' ? JSON.parse(val) : val;
      } catch(e) {
        return { text: val };
      }
    },
    quoteText() {
      const { text = '' } = this.parsedQuoteData;
      return text;
    },
    authorText() {
      const { text = '' } = this.parsedAuthorData;
      return text;
    },
    quoteAlign() {
      const { align = 'left' } = this.parsedQuoteData;
      return align;
    },
    authorAlign() {
      const { align = 'left' } = this.parsedAuthorData;
      return align;
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
div.pwquote {
	div.quote,
	div.author {
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