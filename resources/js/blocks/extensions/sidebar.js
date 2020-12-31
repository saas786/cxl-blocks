/**
 * Adds the CXL Blocks Sidebar to the Block Editor.
 *
 * Exposes a 'CXLBlocksSidebar' slot. Other components can use portal rendering
 * to appear inside the Genesis sidebar by wrapping themselves in a Fill
 * component. First, import the Fill component:
 *
 * `import { Fill } from '@wordpress/components';`
 *
 * Then wrap your own component in a Fill component:
 *
 * `<Fill name="CXLBlocksSidebar">I'm in the CXL Blocks sidebar</Fill>`
 *
 * @since   2021.01.05
 * @package
 */

/**
 * WordPress dependencies
 */
/**
 * Internal dependencies
 */
import { CXLBlocksIcon, CXLBlocksSmall } from '../../utils/brand-assets';

const { Fragment } = wp.element;
const { registerPlugin } = wp.plugins;
const { PluginSidebar, PluginSidebarMoreMenuItem } = wp.editPost;
const { Slot } = wp.components;

// CXL Blocks Sidebar Component
const render = () => {
	return (
		<Fragment>
			<PluginSidebarMoreMenuItem
				target="cxl-blocks-sidebar"
				icon={<CXLBlocksSmall />}
			>
				CXL
			</PluginSidebarMoreMenuItem>
			<PluginSidebar
				name="cxl-blocks-sidebar"
				title="CXL"
				icon={<CXLBlocksIcon />}
			>
				<Slot name="CXLBlocksSidebar" />
			</PluginSidebar>
		</Fragment>
	);
};

registerPlugin('cxl-blocks-sidebar', { render, icon: <CXLBlocksSmall /> });
