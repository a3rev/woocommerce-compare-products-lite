import Inspector from './inspector';

/**
 * WordPress dependencies
 */
const {
	BlockControls,
	useBlockProps,
} = wp.blockEditor || wp.editor;

const {
	Fragment
} = wp.element;

export default function CompareListEdit( props ) {
	const blockProps = useBlockProps();

	const containerElement = (
		<div { ...blockProps }>
			<img
				src={ compare_list_block_editor.preview }
			/>
		</div>
	);

	return (
		<Fragment>
			<Inspector { ...{ ...props } } />
			<BlockControls group="block" />
			{ containerElement }
		</Fragment>
	);
}
