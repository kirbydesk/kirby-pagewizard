// Blocks
import footer from "@/blocks/footer/index.vue";
import footerItem from "@/blocks/footer/item.vue";
import socialmedia from "@/blocks/footer/index.vue";
import socialmediaItem from "@/blocks/footer/item.vue";

// Render
panel.plugin("chrfickinger/kirby-pages", {
  blocks: {
		footer: footer,
		footerItem: footerItem,
		socialmedia: socialmedia,
		socialmediaItem: socialmediaItem
	},
});