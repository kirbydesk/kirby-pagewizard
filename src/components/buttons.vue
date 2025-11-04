<template>
	<div v-if="value.length" class="k-button-group">

		<div v-for="item in value" :key="item.id" :class="{'ishidden': item.isHidden}">
			<button v-if="item.content.link.length"
				type="button"
				class="k-button"
				data-has-text="true"
				data-responsive="true"
				data-size="md"
				data-variant="filled"
			>
				<span v-if="item.content.linktext.length" class="k-button-text"> {{item.content.linktext}} </span>
				<em v-else class="k-button-text placeholder"> {{ $t('pw.field.linktext.placeholder') }} </em>

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
	margin-top: var(--spacing-4);
}
button {
	margin-top: var(--spacing-1);
	padding: var(--spacing-4) var(--spacing-2);
	color: var(--button-primary-textcolor);
	background-color: var(--button-primary-backgroundcolor);
}
</style>