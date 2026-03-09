<template>
	<div class="pwPreview" data-kirbyblock="shared" @dblclick="open">
		<div class="shared">
			<div class="name">
				<k-icon v-if="icon" :type="icon" />
				<span class="blockname">{{ blockName }}:</span>
			</div>
			<div class="sharedname">{{ label }}</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return { sharedItems: [] }
	},
	computed: {
		label() {
			const item = this.sharedItems.find(i => i.value === this.content.sharedid);
			return item?.label || this.content.sharedid || '';
		},
		icon() {
			const item = this.sharedItems.find(i => i.value === this.content.sharedid);
			return item?.icon || null;
		},
		blockName() {
			const item = this.sharedItems.find(i => i.value === this.content.sharedid);
			return item?.name || '';
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
<style scoped>
div.shared {
	display: flex;
	align-items: center;
	gap: var(--spacing-2);
	color: white;
	padding: var(--spacing-4) var(--spacing-5);
	border-radius: var(--rounded-md);
	background-color: color-mix(in srgb, var(--color-blue-600) 85%, transparent);

	div.name {
		display: flex;
		align-items: center;
		gap: .15rem;
		opacity: 0.7;
	}
}
</style>
