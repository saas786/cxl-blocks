/**
 * CXL Brand Icons for use in React components.
 *
 * Wrapping these icons in the WordPress SVG component instead of using SVGs
 * directly ensures icons remain accessible in all browsers.
 *
 * See https://developer.wordpress.org/block-editor/components/svg/.
 *
 */

/**
 * WordPress dependencies
 */
const { Path, SVG, G } = wp.components;

const CXLBlocksIconPath = () => (
	<>
		<Path
			d="M18.314 15.7267C18.175 17.3617 17.6354 18.815 16.695 20.0867C15.7653 21.3584 14.5364 22.3361 13.0082 23.0201C11.4908 23.704 9.84513 24.0299 8.07122 23.9978C5.63476 23.9444 3.71659 23.159 2.31669 21.6415C0.916797 20.1241 0.152732 18.067 0.0244976 15.4702C-0.0716783 13.7391 0.115331 11.853 0.585524 9.8119C1.0664 7.77083 1.84115 5.99692 2.90978 4.49016C3.98908 2.97272 5.2554 1.83998 6.70873 1.09194C8.17274 0.333222 9.77033 -0.0301091 11.5015 0.00194951C14.0448 0.0446944 16.0538 0.808759 17.5285 2.29414C19.0139 3.77953 19.8207 5.82594 19.9489 8.43337L14.4829 8.41734C14.5043 6.99608 14.2479 5.98089 13.7135 5.37177C13.1792 4.76266 12.335 4.43673 11.1809 4.39398C8.29563 4.29781 6.53775 6.54191 5.90726 11.1263C5.61873 13.1994 5.47447 14.6795 5.47447 15.5664C5.42104 18.1952 6.39348 19.547 8.3918 19.6218C9.68484 19.6646 10.7161 19.3493 11.4855 18.6761C12.2549 17.9922 12.7464 17.0304 12.9602 15.7908L18.314 15.7267Z"
			fill="var(--lumo-primary-color, #D61F2C)"
		/>
		<Path
			d="M30.7679 8.09676L34.5829 0.338565H41.0107L34.4867 11.9117L41.187 23.6773H34.6951L30.7679 15.7748L26.8407 23.6773H20.3649L27.0491 11.9117L20.5412 0.338565H26.9529L30.7679 8.09676Z"
			fill="var(--lumo-primary-color, #D61F2C)"
		/>
		<Path
			d="M49.2541 19.3493H59.048V23.6773H43.6278V0.338565H49.2541V19.3493Z"
			fill="var(--lumo-primary-color, #D61F2C)"
		/>
	</>
);

export const CXLBlocksIcon = () => (
	<SVG
		viewBox="0 0 60 24"
		xmlns="http://www.w3.org/2000/svg"
		preserveAspectRatio="xMidYMid meet"
		focusable="false"
		width="60"
		height="24"
	>
		<G width="60" height="24" viewBox="0 0 60 24">
			<CXLBlocksIconPath />
		</G>
	</SVG>
);

export const CXLBlocksSmall = () => (
	<SVG
		viewBox="0 0 54 22"
		xmlns="http://www.w3.org/2000/svg"
		preserveAspectRatio="xMidYMid meet"
		focusable="false"
		width="54"
		height="22"
	>
		<G width="54" height="22" viewBox="0 0 54 22">
			<CXLBlocksIconPath />
		</G>
	</SVG>
);
