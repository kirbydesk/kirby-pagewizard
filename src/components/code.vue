<template>
  <div class="pwCode" style="margin-top:var(--spacing-2);">
    <pre><code ref="code" :class="languageClass"></code></pre>
  </div>
</template>

<script>
import hljs from 'highlight.js/lib/core';

// Import languages
import bash from 'highlight.js/lib/languages/bash';
import basic from 'highlight.js/lib/languages/basic';
import c from 'highlight.js/lib/languages/c';
import clojure from 'highlight.js/lib/languages/clojure';
import cpp from 'highlight.js/lib/languages/cpp';
import csharp from 'highlight.js/lib/languages/csharp';
import css from 'highlight.js/lib/languages/css';
import diff from 'highlight.js/lib/languages/diff';
import elixir from 'highlight.js/lib/languages/elixir';
import elm from 'highlight.js/lib/languages/elm';
import erlang from 'highlight.js/lib/languages/erlang';
import go from 'highlight.js/lib/languages/go';
import graphql from 'highlight.js/lib/languages/graphql';
import haskell from 'highlight.js/lib/languages/haskell';
import java from 'highlight.js/lib/languages/java';
import javascript from 'highlight.js/lib/languages/javascript';
import json from 'highlight.js/lib/languages/json';
import latex from 'highlight.js/lib/languages/latex';
import less from 'highlight.js/lib/languages/less';
import lisp from 'highlight.js/lib/languages/lisp';
import lua from 'highlight.js/lib/languages/lua';
import makefile from 'highlight.js/lib/languages/makefile';
import markdown from 'highlight.js/lib/languages/markdown';
import objectivec from 'highlight.js/lib/languages/objectivec';
import perl from 'highlight.js/lib/languages/perl';
import php from 'highlight.js/lib/languages/php';
import plaintext from 'highlight.js/lib/languages/plaintext';
import python from 'highlight.js/lib/languages/python';
import r from 'highlight.js/lib/languages/r';
import ruby from 'highlight.js/lib/languages/ruby';
import rust from 'highlight.js/lib/languages/rust';
import scss from 'highlight.js/lib/languages/scss';
import shell from 'highlight.js/lib/languages/shell';
import sql from 'highlight.js/lib/languages/sql';
import swift from 'highlight.js/lib/languages/swift';
import typescript from 'highlight.js/lib/languages/typescript';
import vbnet from 'highlight.js/lib/languages/vbnet';
import xml from 'highlight.js/lib/languages/xml';
import yaml from 'highlight.js/lib/languages/yaml';

import 'highlight.js/styles/github-dark.css';

// Register languages
hljs.registerLanguage('bash', bash);
hljs.registerLanguage('basic', basic);
hljs.registerLanguage('c', c);
hljs.registerLanguage('clojure', clojure);
hljs.registerLanguage('cpp', cpp);
hljs.registerLanguage('csharp', csharp);
hljs.registerLanguage('css', css);
hljs.registerLanguage('diff', diff);
hljs.registerLanguage('elixir', elixir);
hljs.registerLanguage('elm', elm);
hljs.registerLanguage('erlang', erlang);
hljs.registerLanguage('go', go);
hljs.registerLanguage('graphql', graphql);
hljs.registerLanguage('haskell', haskell);
hljs.registerLanguage('java', java);
hljs.registerLanguage('javascript', javascript);
hljs.registerLanguage('json', json);
hljs.registerLanguage('latex', latex);
hljs.registerLanguage('less', less);
hljs.registerLanguage('lisp', lisp);
hljs.registerLanguage('lua', lua);
hljs.registerLanguage('makefile', makefile);
hljs.registerLanguage('markdown', markdown);
hljs.registerLanguage('objectivec', objectivec);
hljs.registerLanguage('perl', perl);
hljs.registerLanguage('php', php);
hljs.registerLanguage('plaintext', plaintext);
hljs.registerLanguage('python', python);
hljs.registerLanguage('r', r);
hljs.registerLanguage('ruby', ruby);
hljs.registerLanguage('rust', rust);
hljs.registerLanguage('scss', scss);
hljs.registerLanguage('shell', shell);
hljs.registerLanguage('sql', sql);
hljs.registerLanguage('swift', swift);
hljs.registerLanguage('typescript', typescript);
hljs.registerLanguage('vbnet', vbnet);
hljs.registerLanguage('xml', xml);
hljs.registerLanguage('yaml', yaml);

export default {
  props: {
    value: String,
    syntaxhighlighting: String
  },
  computed: {
    languageClass() {
      return this.syntaxhighlighting
        ? `language-${this.syntaxhighlighting}`
        : 'plaintext';
    },
    codeContent() {
      // Hier wird der Placeholder gesetzt, falls value leer ist
      return (this.value !== undefined && this.value !== null && String(this.value).length > 0)
        ? this.value
        : `</> ${this.syntaxhighlighting}`;
    }
  },
  mounted() {
    this.highlight();
  },
  updated() {
    this.highlight();
  },
  watch: {
    syntaxhighlighting() {
      this.$nextTick(() => {
        this.highlight();
      });
    },
    value() {
      this.$nextTick(() => {
        this.highlight();
      });
    }
  },
  methods: {
    highlight() {
      if (this.$refs.code) {
        this.$refs.code.textContent = this.codeContent;
        this.$refs.code.removeAttribute('data-highlighted');
        hljs.highlightElement(this.$refs.code); // immer anwenden
      }
    }
  }
}
</script>
<style scoped>
.pwCode {
	pre code {
		margin-top: var(--spacing-4);
		line-height: 1.4em;
		border-bottom-left-radius: var(--rounded-md);
		border-bottom-right-radius: var(--rounded-md);
	}
}
</style>
