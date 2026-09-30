<?php

/**
 * The blocks field of the pages and the shared blocks (field type
 * "pwblocks"): Kirby's blocks field as it is – its own type, so the panel
 * can add to it (the Project Wizard: the device of the block previews next
 * to "Add") without touching Kirby's own blocks field, which the nested
 * blocks (steps, buttons, cards …) keep using.
 */
class PwblocksField extends \Kirby\Form\Field\BlocksField
{
}
