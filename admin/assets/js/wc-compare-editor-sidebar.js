( function ( wp ) {
	var registerPlugin   = wp.plugins.registerPlugin;
	var PluginDocumentSettingPanel = wp.editor.PluginDocumentSettingPanel
		|| ( wp.editPost && wp.editPost.PluginDocumentSettingPanel );
	var el               = wp.element.createElement;
	var Fragment         = wp.element.Fragment;
	var useSelect        = wp.data.useSelect;
	var useDispatch      = wp.data.useDispatch;
	var ToggleControl    = wp.components.ToggleControl;
	var SelectControl    = wp.components.SelectControl;
	var TextControl      = wp.components.TextControl;
	var TextareaControl  = wp.components.TextareaControl;
	var CheckboxControl  = wp.components.CheckboxControl;
	var RadioControl     = wp.components.RadioControl;
	var BaseControl      = wp.components.BaseControl;
	var __               = wp.i18n.__;

	if ( ! PluginDocumentSettingPanel || ! useSelect || ! useDispatch ) {
		return;
	}

	var editorData      = window.wcCompareEditorData || {};
	var categories      = editorData.categories || [];
	var categoryFields  = editorData.categoryFields || {};
	var addFeaturesUrl  = editorData.addFeaturesUrl || '';

	var categoryOptions = [ { value: '0', label: __( 'Select...', 'woocommerce-compare-products' ) } ].concat( categories );

	function renderField( field, meta, editPost ) {
		var metaKey = '_woo_compare_' + field.key;
		var value   = meta[ metaKey ];
		var label   = field.name;
		if ( field.unit ) {
			label += ' (' + field.unit + ')';
		}

		switch ( field.type ) {
			case 'text-area':
				return el( TextareaControl, {
					key: metaKey,
					label: label,
					value: value || '',
					onChange: function ( v ) {
						var u = {};
						u[ metaKey ] = v;
						editPost( { meta: u } );
					}
				} );

			case 'checkbox':
				var checked = Array.isArray( value ) ? value : [];
				return el( BaseControl, { key: metaKey, label: label, className: 'wc-compare-checkbox-group' },
					field.options.map( function ( opt ) {
						return el( CheckboxControl, {
							key: metaKey + '-' + opt,
							label: opt,
							checked: checked.indexOf( opt ) !== -1,
							onChange: function ( isChecked ) {
								var next = checked.slice();
								if ( isChecked ) {
									if ( next.indexOf( opt ) === -1 ) next.push( opt );
								} else {
									next = next.filter( function ( v ) { return v !== opt; } );
								}
								var u = {};
								u[ metaKey ] = next;
								editPost( { meta: u } );
							}
						} );
					} )
				);

			case 'radio':
				return el( RadioControl, {
					key: metaKey,
					label: label,
					selected: value || '',
					options: field.options.map( function ( opt ) {
						return { label: opt, value: opt };
					} ),
					onChange: function ( v ) {
						var u = {};
						u[ metaKey ] = v;
						editPost( { meta: u } );
					}
				} );

			case 'drop-down':
				var ddOpts = [ { value: '', label: __( 'Select value', 'woocommerce-compare-products' ) } ];
				field.options.forEach( function ( opt ) {
					ddOpts.push( { value: opt, label: opt } );
				} );
				return el( SelectControl, {
					key: metaKey,
					label: label,
					value: value || '',
					options: ddOpts,
					onChange: function ( v ) {
						var u = {};
						u[ metaKey ] = v;
						editPost( { meta: u } );
					}
				} );

			case 'multi-select':
				var selected = Array.isArray( value ) ? value : [];
				return el( SelectControl, {
					key: metaKey,
					label: label,
					value: selected,
					multiple: true,
					options: field.options.map( function ( opt ) {
						return { value: opt, label: opt };
					} ),
					onChange: function ( v ) {
						var u = {};
						u[ metaKey ] = v;
						editPost( { meta: u } );
					}
				} );

			default:
				return el( TextControl, {
					key: metaKey,
					label: label,
					value: value || '',
					onChange: function ( v ) {
						var u = {};
						u[ metaKey ] = v;
						editPost( { meta: u } );
					}
				} );
		}
	}

	var CompareProductsPanel = function () {
		var meta = useSelect( function ( select ) {
			return select( 'core/editor' ).getEditedPostAttribute( 'meta' ) || {};
		}, [] );

		var editPost = useDispatch( 'core/editor' ).editPost;

		var isActive        = meta._woo_deactivate_compare_feature === 'no';
		var currentCategory = meta._woo_compare_category || '0';

		var children = [
			el( ToggleControl, {
				key: 'toggle',
				label: __( 'Activate Compare Feature', 'woocommerce-compare-products' ),
				checked: isActive,
				onChange: function ( v ) {
					editPost( { meta: { _woo_deactivate_compare_feature: v ? 'no' : 'yes' } } );
				}
			} )
		];

		if ( isActive ) {
			children.push(
				el( SelectControl, {
					key: 'category',
					label: __( 'Compare Category', 'woocommerce-compare-products' ),
					value: currentCategory,
					options: categoryOptions,
					onChange: function ( v ) {
						editPost( { meta: { _woo_compare_category: v } } );
					}
				} )
			);

			if ( currentCategory !== '0' ) {
				var fields = categoryFields[ currentCategory ] || [];
				if ( fields.length > 0 ) {
					fields.forEach( function ( field ) {
						children.push( renderField( field, meta, editPost ) );
					} );
				} else {
					children.push(
						el( 'p', { key: 'no-fields', style: { fontStyle: 'italic' } },
							__( 'There are no Features created for this category, please add some.', 'woocommerce-compare-products' ),
							' ',
							el( 'a', { href: addFeaturesUrl, target: '_blank' },
								__( 'This page', 'woocommerce-compare-products' )
							)
						)
					);
				}
			}
		}

		return el(
			PluginDocumentSettingPanel,
			{
				name: 'wc-compare-products',
				title: __( 'Compare Products', 'woocommerce-compare-products' ),
				initialOpen: true
			},
			children
		);
	};

	registerPlugin( 'wc-compare-products', {
		render: CompareProductsPanel,
		icon: 'products'
	} );
} )( window.wp );
