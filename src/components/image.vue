<template>
  <div class="image" :class="size">
		<div class="pattern">
			<figure
				class="k-frame k-image-frame k-image"
				:class="{ 'zoom': zoom }"
				:style="{
					'--fit': crop ? 'cover' : 'contain',
					'--ratio': ratio || '1/1'
				}"
			>
				<img v-if="src.length"
					:src="src"
					:srcset="srcset"
				/>
				<div><k-icon type="search"></k-icon></div>
			</figure>
		</div>
		<div v-if="count > 1" class="dots">
			<span v-for="n in count" :key="n" class="dot"></span>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		src: String,
		srcset: String,
		crop: String,
		ratio: String,
		size: String,
		zoom: String,
		count: {
			type: Number,
			default: 0
		}
  }
}
</script>

<style scoped>
div.image {
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
	div.image {
		&.small {
			width: 25%;
		}
		&.medium {
			width: 50%;
		}
		&.large {
			width: 75%;
		}
		&.fullscreen {
			width: 100%;
		}
	}
}
</style>