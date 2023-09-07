/**
 * External dependencies
 */
import classnames from 'classnames';

import Inspector from './inspector';

/**
 * WordPress dependencies
 */
const {
	AlignmentControl,
	BlockControls,
	useBlockProps,
	RichText,
	__experimentalUseBorderProps: useBorderProps,
	__experimentalUseColorProps: useColorProps,
	__experimentalGetSpacingClassesAndStyles: useSpacingProps,
	__experimentalGetElementClassName,
} = wp.blockEditor || wp.editor;
const { __ } = wp.i18n;

const {
	useEffect,
	Fragment
} = wp.element;

export default function InquiryButtonEdit( props ) {
	const {
		attributes,
		setAttributes,
		className,
	} = props;

	const {
		content,
		textAlign,
		width,
	} = attributes;

	const borderProps = useBorderProps( attributes );
	const colorProps = useColorProps( attributes );
	const spacingProps = useSpacingProps( attributes );

	const blockProps = useBlockProps();

	return (
		<Fragment>
			<Inspector { ...{ ...props } } />
			<div
				className={ classnames( 
					attributes.className,
					'wp-block-button',
					{
						[ `has-custom-width wp-block-button__width-${ width }` ]: width,
						[ `has-custom-font-size` ]: blockProps.style.fontSize,
						[ `has-text-align-${ textAlign }` ]: textAlign,
					}
				) }
			>
				<RichText
					tagName="a"
					aria-label={ __( 'Compare Button' ) }
					placeholder={ __( 'Compare This*' ) }
					value={ content }
					onChange={ ( newValue ) =>
						setAttributes( { content: newValue } )
					}
					withoutInteractiveFormatting={ true }
					{ ...blockProps }
					className={ classnames(
						className,
						'wp-block-button__link',
						'wp-element-button',
						colorProps.className,
						borderProps.className,
						__experimentalGetElementClassName( 'button' )
					) }
				/>
			</div>
			<BlockControls group="block">
				<AlignmentControl
					value={ textAlign }
					onChange={ ( nextAlign ) => {
						setAttributes( { textAlign: nextAlign } );
					} }
				/>
			</BlockControls>
		</Fragment>
	);
}
