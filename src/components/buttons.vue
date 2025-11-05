<template>
	<div class="k-button-group" v-if="value && value.length">
		<div v-for="item in value" :key="item.id" :class="{'ishidden': item.isHidden}">
			<button
				type="button"
				class="k-button"
				data-has-text="true"
				data-responsive="true"
				data-size="md"
				data-variant="filled"
			>
			<span v-if="item.content.linktext.length" class="k-button-text"> {{item.content.linktext}} </span>
			<span v-else class="k-button-text placeholder"> {{ $t('pw.field.link-text.placeholder') }} </span>
			</button>
		</div>
	</div>
</template>
<script>
export default {
	props: {
		value: String,
	}
}
</script>
<style scoped>
.k-button-group {
	margin: var(--spacing-4) 0 var(--spacing-2);
}
button {
	padding: var(--spacing-4) var(--spacing-2);
	background-color: var(--color-gray-600);
	color: white;

	.k-button-text.placeholder {
		color: white;
	}
}
</style>