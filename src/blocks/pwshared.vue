<template>
	<div class="pwPreview" data-kirbyblock="shared" @dblclick="open">
		<pwBlockinfo
			:value="label"
			icon="share"
		/>
		<div class="pwGrid">
			<div class="pwGridItem">
				<div class="contents">
					<p class="pwshared-label">{{ label }}</p>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import pwBlockinfo from '@/components/blockinfo.vue';

export default {
	components: { pwBlockinfo },
	data() {
		return { sharedItems: [] }
	},
	computed: {
		label() {
			const item = this.sharedItems.find(i => i.value === this.content.sharedid);
			if (!item) return this.content.sharedid;
			return item.label + (item.type ? ' (' + item.type + ')' : '');
		}
	},
	async created() {
		try {
			const r = await this.$api.get('pagewizard/shared');
			this.sharedItems = Array.isArray(r) ? r : [];
		} catch(e) {
			this.sharedItems = [];
		}
	}
}
</script>
