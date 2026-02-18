<template>
	<div class="wrap" v-if="src.length" :data-align="alignment">
		<div class="image">
			<div class="pattern" :class="size">
				<figure
					class="k-frame k-image-frame k-image"
					:class="{ 'zoom': computedZoom }"
					:style="{
						'--fit': computedCrop ? 'cover' : 'contain',
						'--ratio': computedRatio
					}"
				>
					<img :src="src" :srcset="srcset" />
					<div><k-icon type="search"></k-icon></div>
				</figure>
			</div>
		</div>
		<div v-if="count > 1" class="controls">
			<div class="dots" :class="size">
				<span v-for="n in count" :key="n" class="dot"></span>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		src: String,
		srcset: String,
		size: String,
		alignment: {
			type: String,
			default: 'left'
		},
		image: Object,
		count: {
			type: Number,
			default: 0
		}
  },
	data() {
		return {
			imageContent: null
		}
	},
	computed: {
		computedCrop() {
			return this.imageContent?.imagecrop || false;
		},
		computedRatio() {
			return this.imageContent?.imageratio || '1/1';
		},
		computedZoom() {
			return this.imageContent?.imagezoom || false;
		}
	},
	async mounted() {
		if (this.image?.link) {
			await this.loadImageContent();
		}
	},
	methods: {
		async loadImageContent() {
			try {
				const response = await this.$api.get(this.image.link);
				this.imageContent = response?.content || null;
			} catch (error) {
				console.error('Error loading image content:', error);
			}
		}
	}
}
</script>

<style scoped>
div.wrap {
	&[data-align="left"] div.image,
	&[data-align="left"] div.controls {
		justify-content: flex-start;
	}
	&[data-align="center"] div.image,
	&[data-align="center"] div.controls {
		justify-content: center;
	}
	&[data-align="right"] div.image,
	&[data-align="right"] div.controls {
		justify-content: flex-end;
	}
}

div.image, div.controls {
	display: block;
	width: 100%;

	div.pattern {
		background: var(--pattern);
	}

	figure {
		position: relative;

		img + div {
			position: absolute;
			right: -99999px;
			bottom: 0;
		}

		&.zoom img + div {
			display: block;
			bottom: 0;
			right: 0;
			z-index: 999;
			background-color: black;
			opacity: 0.7;
			padding: var(--spacing-1);

			svg {
				fill: white;
			}
		}
	}
}
.dots {
  margin: var(--spacing-2) 0 0;
  text-align: center;
}
.dot {
  display: inline-block;
  width: 8px;
  height: 8px;
  margin: 0 2px;
  border-radius: 50%;
  background: var(--color-text-dimmed);
}

@media (min-width: 640px) {
	div.image, div.controls {
		display: flex;
	}
	.xsmall { width: 100%;max-width: 25%;}
	.small { width: 100%;max-width: 33%;}
	.medium { width: 100%;max-width: 50%;}
	.large { width: 100%;max-width: 75%;}
	.fullscreen { width: 100%;max-width: 100%;}
}

</style>







