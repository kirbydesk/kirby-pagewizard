// Styles
import "./css/panel.css";

// Blocks
import footer from "@/blocks/footer/index.vue";
import footerItem from "@/blocks/footer/item.vue";

// Render
panel.plugin("kirbydesk/kirby-pagewizard", {
  blocks: {
		footer: footer,
		footerItem: footerItem
	},
});
