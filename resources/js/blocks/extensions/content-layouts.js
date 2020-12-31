/* eslint react/prop-types: 0 */

/**
 * Adds a “layout toggle” to the Block Editor sidebar under the
 * Document sidebar. No layout selected by default.
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
import { newMeta } from '../../utils/block-helpers';

const { __ } = wp.i18n;
const { Fragment, Component } = wp.element;
const { compose } = wp.compose;
const { select, withSelect, withDispatch } = wp.data;
const { registerPlugin } = wp.plugins;
const { SelectControl, Fill, Panel, PanelBody, Spinner } = wp.components;
const { apiFetch } = wp;

class cxlBlocksLayoutToggleComponent extends Component {
	constructor(props) {
		super(props);

		this.state = {
			layouts: [],
		};
	}

	componentDidMount() {
		// Show CXL Blocks content layouts of type [postType-ID], [postType], 'singular', then 'site' in that order.
		const { currentPostType, currentPostID } = this.props;
		const layoutsEndpoint = `/cxlblocks/v1/layouts/singular,${currentPostType},${currentPostID}`;
		apiFetch({ path: layoutsEndpoint }).then((collection) => {
			const stack = [];

			for (const slug of Object.keys(collection)) {
				stack.push({
					label: collection[slug].label,
					value: slug,
				});
			}

			this.setState({ layouts: stack });
		});
	}

	render() {
		const { layouts } = this.state;
		const { layout, onChange } = this.props;
		return (
			<Fragment>
				<Fill name="CXLBlocksSidebar">
					<Panel>
						<PanelBody initialOpen title={__('Layout', 'cxl-blocks')}>
							{layouts.length ? (
								<SelectControl
									label={__('Select Layout', 'cxl-blocks')}
									value={layout}
									options={layouts}
									onChange={(layout) => onChange(layout)}
								/>
							) : (
								<Spinner />
							)}
						</PanelBody>
					</Panel>
				</Fill>
			</Fragment>
		);
	}
}

// Retrieves meta from the Block Editor Redux store (withSelect) to set initial checkbox state.
// Persists it to the Redux store on change (withDispatch).
// Changes are only stored in the WordPress database when the post is updated.
const render = compose([
	withSelect(() => {
		const { getEditedPostAttribute } = select('core/editor');
		const { contentLayouts } = cxlBlockSettings;
		const { layoutKey } = contentLayouts;
		let layoutValue = getEditedPostAttribute('meta')
			[ layoutKey ];

		return {
			layout: layoutValue,
			currentPostID: select('core/editor').getCurrentPostId(),
			currentPostType: select('core/editor').getCurrentPostType(),
		};
	}),
	withDispatch((dispatch) => ({
		onChange(layout) {

			const { contentLayouts } = cxlBlockSettings;
			const { layoutKey } = contentLayouts;

			dispatch('core/editor').editPost({
				meta: newMeta(layoutKey, layout, ''),
			});
		},
	})),
])(cxlBlocksLayoutToggleComponent);

registerPlugin('cxl-blocks-content-layout', { render });
