// (function (blocks, editor, element) {
//     var el = element.createElement;
//     var registerBlockType = blocks.registerBlockType;
//     var RichText = editor.RichText;

//     registerBlockType('project-management/blocks', {
//         title: 'My Block',
//         icon: 'smiley',
//         category: 'common',
//         attributes: {
//             content: {
//                 type: 'string',
//                 source: 'html',
//                 selector: 'p',
//             },
//         },
//         edit: function (props) {
//             var content = props.attributes.content;

//             function onChangeContent(newContent) {
//                 props.setAttributes({ content: newContent });
//             }

//             return el(RichText, {
//                 tagName: 'p',
//                 className: props.className,
//                 onChange: onChangeContent,
//                 value: content,
//             });
//             // return el(
//             //     'h1',
//             //     "hello ca nha yeu"
//             // )
//         },
//         save: function (props) {
//             return el(RichText.Content, {
//                 tagName: 'p',
//                 value: props.attributes.content,
//             });
//         },
//     });
// })(
//     window.wp.blocks,
//     window.wp.editor,
//     window.wp.element
// );


(function (blocks, element, editor, components) {
    var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;
    var ToggleControl = components.ToggleControl;
    var ColorPalette = components.ColorPicker;

    registerBlockType('project-management/blocks', {
        title: 'Your Block',
        icon: 'smiley',
        category: 'common',
        attributes: {
            color: {
                type: 'string',
                default: 'black',
            },
            label: {
                type: 'string',
                default: 'Default Label',
            },
            disable: {
              type: 'boolean',
              default: false,
            },
            id: {
                type: 'string',
                default: '',
            },
            class: {
                type: 'string',
                default: '',
            },
        },
        edit: function (props) {
            var attributes = props.attributes;
            var setColor = function (newColor) {
                props.setAttributes({ color: newColor.hex });
            };
            var setLabel = function (newLabel) {
                props.setAttributes({ label: newLabel });
            };
            var setId = function (newId) {
                props.setAttributes({ id: newId });
            };
            var setClass = function (newClass) {
                props.setAttributes({ class: newClass });
            };
            var setDisable = function (isDisabled) {
                props.setAttributes({ disable: isDisabled  });
            };

            return el(
                'div',
                { className: 'your-block-editor' },
                el(ToggleControl, {
                    label: 'Toggle Color',
                    checked: attributes.disable,
                    onChange: setDisable, 
                }),
                el(editor.InspectorControls, { key: 'inspector' },
                    el(components.PanelBody, {
                        title: 'Block Settings',
                        initialOpen: true,
                    },
                        el(components.TextControl, {
                            label: 'Label',
                            value: attributes.label,
                            onChange: setLabel,
                        }),
                        el(components.TextControl, {
                            label: 'ID',
                            value: attributes.id,
                            onChange: setId,
                        }),
                        el(components.TextControl, {
                            label: 'Class',
                            value: attributes.class,
                            onChange: setClass,
                        }),
                        el(ColorPalette, {
                            value: attributes.color,
                            onChangeComplete: setColor,
                            // onChange: setColor,
                            // colors: [
                            //     { name: 'Black', color: 'black' },
                            //     { name: 'Red', color: 'red' },
                            //     { name: 'Blue', color: 'blue' },
                            //     // Add more colors as needed
                            // ],
                        })
                    )
                )
            );
        },
        save: function (props) {
            var attributes = props.attributes;
            return el('div', {
                className: 'blocks',
                style: { color: attributes.color },
                id: attributes.id,
                class: attributes.class,
                disabled: attributes.disable,
            },
                el('button', { className: 'your-toggle-button' }, attributes.label)
            );
        },
    });

})(
    window.wp.blocks,
    window.wp.element,
    window.wp.editor,
    window.wp.components
);
