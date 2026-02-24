<template>
  <k-panel-inside class="pw-icons-view">
    <k-header>
      {{ $t('pw.icon.reference') }}
      <template #right>
        <k-button-group>
          <k-button
            v-for="s in sets"
            :key="s"
            :text="s"
            :theme="activeSet === s ? 'positive' : null"
            variant="filled"
            size="sm"
            @click="loadSet(s)"
          />
        </k-button-group>
      </template>
    </k-header>

    <div class="pw-icons-search">
      <k-input
        type="text"
        :placeholder="$t('pw.icon.search')"
        :value="search"
        @input="search = $event"
      />
      <span class="pw-icons-count">{{ filtered.length }} / {{ icons.length }}</span>
    </div>

    <div class="pw-icons-grid">
      <button
        v-for="icon in filtered"
        :key="icon.id"
        class="pw-icons-item"
        :class="{ 'is-custom': icon.custom }"
        :title="icon.id"
        @click="copy(icon.id)"
      >
        <span class="pw-icons-svg" v-html="icon.svg"></span>
        <span class="pw-icons-label">{{ icon.id }}</span>
      </button>
    </div>

    <k-notification v-if="copied" theme="positive" type="alert">
      "{{ copied }}" {{ $t('pw.icon.copied') }}
    </k-notification>
  </k-panel-inside>
</template>

<script>
export default {
  data() {
    return {
      sets:      [],
      activeSet: null,
      icons:     [],
      search:    '',
      copied:    null,
    };
  },
  computed: {
    filtered() {
      const q = this.search.trim().toLowerCase();
      if (!q) return this.icons;
      return this.icons.filter(i => i.id.toLowerCase().includes(q));
    },
  },
  async created() {
    try {
      this.sets = await this.$api.get('pagewizard/icons/sets');
      if (this.sets.length) {
        const preferred = this.sets.find(s => s !== 'custom') || this.sets[0];
        await this.loadSet(preferred);
      }
    } catch(e) {}
  },
  methods: {
    async loadSet(set) {
      this.activeSet = set;
      this.search    = '';
      try {
        const res  = await this.$api.get('pagewizard/icons/' + set);
        this.icons = Array.isArray(res) ? res : [];
      } catch(e) {
        this.icons = [];
      }
    },
    async copy(id) {
      try {
        await navigator.clipboard.writeText(id);
        this.copied = id;
        setTimeout(() => { this.copied = null; }, 2000);
      } catch(e) {}
    },
  },
};
</script>
