/**
 * Internal dependencies
 */

/**
 * Inspector controls
 */

const { __ } = wp.i18n;

const {
	PanelBody,
	TextControl,
} = wp.components;

const {
	InspectorControls,
} = wp.blockEditor || wp.editor;

const { Component, Fragment } = wp.element;

export default class Inspector extends Component {
	render() {
		const {
			attributes: {
				title
			},
			setAttributes,
		} = this.props;

		return (
			<InspectorControls>
				<PanelBody title={ __( 'Settings' ) }>
					<TextControl
						label={ __( 'Title' ) }
						help={ __( 'The Title will be included the total products on Compare List. Leave empty for disable the Title' ) }
						value={ title }
						onChange={ ( newTitle ) =>
							setAttributes( { title: newTitle } )
						}
					/>
				</PanelBody>
			</InspectorControls>
	 	);
	}
}