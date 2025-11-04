<template>
  <div class="pwMarkdown">
    <div v-if="value" v-html="renderedMarkdown"></div>
    <div v-else class="placeholder">
      {{ $t('pw.field.text-markdown.placeholder') }}
    </div>
  </div>
</template>

<script>
import { marked } from 'marked';
marked.setOptions({ breaks: true });

export default {
  props: {
    value: String
  },
	computed: {
    renderedMarkdown() {
      let md = this.value || '';
      return marked(md);
    }
  }
}
</script>

<style>
.pwMarkdown {
  line-height: var(--text-line-height);

	h1, h2, h3, h4, h5, h6 {
		font-weight: bold;
		margin:  0 0 .7em 0;
		line-height: 1.2;
	}

}



.pwMarkdown h1 { font-size: 2.0em; }
.pwMarkdown h2 { font-size: 1.5em; }
.pwMarkdown h3 { font-size: 1.2em; }
.pwMarkdown h4,
.pwMarkdown h5,
.pwMarkdown h6 { font-size: 1em; }

.pwMarkdown p {
  margin: 1em 0;
}

.pwMarkdown ul,
.pwMarkdown ol {
  padding: 1em 0 1em 2em;
  margin: 0;
}

.pwMarkdown li {
  padding-bottom: 0.5em;
}

.pwMarkdown pre {
  background: #f6f8fa;
  padding: 1em;
  border-radius: 4px;
  overflow-x: auto;
  font-family: monospace;
  font-size: 0.95em;
  margin: 1em 0;
}

.pwMarkdown code {
  background: #f6f8fa;
  padding: 0.2em 0.4em;
  border-radius: 3px;
  font-family: monospace;
  font-size: 0.95em;
}

.pwMarkdown blockquote {
  border-left: 4px solid #ccc;
  margin: 1em 0;
  padding: 0.5em 1em;
  color: #666;
  background: #f9f9f9;
}

.pwMarkdown a {
  color: #307DCA;
  text-decoration: underline;
  word-break: break-all;
}

.pwMarkdown img {
  max-width: 100%;
  height: auto;
  display: block;
  margin: 1em 0;
}

.pwMarkdown hr {
  border: none;
  border-top: 1px solid #ddd;
  margin: 2em 0;
}

</style>