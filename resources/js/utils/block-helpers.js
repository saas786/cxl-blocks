/**
 * WordPress dependencies
 */
const { registerBlockCollection } = wp.blocks;
const { select } = wp.data;

/**
 * Determine if the block attributes are empty.
 *
 * @param {Object} attributes The block attributes to check.
 * @return {boolean} The empty state of the attributes passed.
 */
export const hasEmptyAttributes = (attributes) => {
	return !Object.entries(attributes)
		.map(([, value]) => {
			if (typeof value === 'string') {
				// eslint-disable-next-line no-param-reassign
				value = value.trim();
			}

			if (value instanceof Array) {
				// eslint-disable-next-line no-param-reassign
				value = value.length;
			}

			if (value instanceof Object) {
				// eslint-disable-next-line no-param-reassign
				value = Object.entries(value).length;
			}

			return !!value;
		})
		.filter((value) => value === true).length;
};

/**
 * Return bool depending on registerBlockCollection compatibility.
 *
 * @return {boolean} Value to indicate function support.
 */
export const supportsCollections = () => {
	if (typeof registerBlockCollection === 'function') {
		return true;
	}
	return false;
};

/**
 * Builds new meta given a new key and value, for use when saving post data.
 *
 * @since   1.0.0
 *
 * Ensures that:
 * 1. Only CXL Blocks meta is updated when saving CXL Blocks settings, fixing
 * https://github.com/studiopress/genesis/issues/2473.
 * 2. A value of 'false' is sent instead of null for empty checkboxes, fixing
 * https://github.com/studiopress/genesis/issues/2523.
 * 3. Checkboxes do not flicker on and off when saving posts. See “additional
 * info” at https://github.com/studiopress/genesis/pull/2474#issue-310416033.
 *
 * @param {string} newKey Meta key
 * @param {*} newValue Meta value
 * @param {*} prefix Meta key prefix
 * @return {Object} CXL Blocks meta keys and values.
 */
export function newMeta(newKey, newValue, prefix = '_cxl_blocks') {
	const currentMeta = select('core/editor').getEditedPostAttribute('meta');
	const cxlBlocksMeta = Object.keys(currentMeta)
		.filter((key) => key.startsWith(prefix))
		.reduce((obj, key) => {
			obj[key] = currentMeta[key];
			if (obj[key] === null) {
				obj[key] = false;
			}
			return obj;
		}, {});

	return {
		...cxlBlocksMeta,
		[newKey]: newValue,
	};
}
