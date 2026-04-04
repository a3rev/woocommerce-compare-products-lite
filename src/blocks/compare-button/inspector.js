/**
 * Internal dependencies
 */

/**
 * Inspector controls
 */

const { __ } = wp.i18n;

const {
	PanelBody,
	__experimentalToggleGroupControl: ToggleGroupControl,
	__experimentalToggleGroupControlOption: ToggleGroupControlOption,
} = wp.components;

const {
	InspectorControls,
} = wp.blockEditor || wp.editor;

const { Component, Fragment } = wp.element;

function WidthPanel( { selectedWidth, setAttributes } ) {
	function handleChange( newWidth ) {
		const width = selectedWidth === newWidth ? undefined : newWidth;
		setAttributes( { width } );
	}

	return (
		<PanelBody title={ __( 'Width settings' ) }>
			<ToggleGroupControl
				__next40pxDefaultSize
				__nextHasNoMarginBottom
				label={ __( 'Button width' ) }
				value={ selectedWidth }
				onChange={ ( value ) => handleChange( value ) }
				isBlock
			>
				{ [ 25, 50, 75, 100 ].map( ( widthValue ) => (
					<ToggleGroupControlOption
						key={ widthValue }
						value={ widthValue }
						label={ `${ widthValue }%` }
					/>
				) ) }
			</ToggleGroupControl>
		</PanelBody>
	);
}

export default class Inspector extends Component {
	render() {
		const {
			attributes: {
				width
			},
			setAttributes,
		} = this.props;

		return (
			<InspectorControls>
				<WidthPanel
					selectedWidth={ width }
					setAttributes={ setAttributes }
				/>
			</InspectorControls>
	 	);
	}
}

