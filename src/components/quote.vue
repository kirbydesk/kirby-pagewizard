<template>
  <div class="pwquote">
    <div v-if="quoteText" class="quote" :data-align="quoteAlign" v-html="nl2br(quoteText)"></div>
    <div v-else class="quote placeholder" :data-align="quoteAlign">
      {{ $t('pw.field.text-quote.placeholder') }}
    </div>
		<div v-if="authorText" class="author" :data-align="authorAlign">{{ authorText }}</div>
    <div v-else class="author placeholder" :data-align="authorAlign">
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
      if (!val) return { text: '', align: 'left', html: false };
      try {
        const d = typeof val === 'string' ? JSON.parse(val) : val;
        if (d.mode !== undefined) {
          return { text: d.writer || d.textarea || d.markdown || '', align: d.align || 'left', html: d.mode === 'writer' };
        }
        return { text: d.text || '', align: d.align || 'left', html: false };
      } catch(e) {
        return { text: val, align: 'left', html: false };
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
      const { text = '', html = false } = this.parsedQuoteData;
      return html ? text : this.nl2br(text);
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
		color: var(--pw-color-quote, inherit);
	}
	div.author {
		margin: var(--spacing-2) 0;
		font-style: italic;
		color: var(--pw-color-cite, inherit);
	}
}
</style>