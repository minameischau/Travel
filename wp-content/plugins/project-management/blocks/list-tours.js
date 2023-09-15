
// Tạo một thư mục con có tên js trong thư mục custom-tour-block.
(function (blocks, element, editor, components) {
    blocks.registerBlockType('custom-tour-block/tour-block', {
        title: 'Custom Tour Block',
        icon: 'smiley',
        category: 'common',
        attributes: blockAttributes,
        edit: function (props) {
            var tours = [
                {
                    post_link: '1',
                    post_image_url: '1',
                    slot_remain: '1',
                    place_start: '1',
                    place_end: '1',
                    day_total: '1',
                    dep_date: '1',
                    price: '1'
                },
                {
                    post_link: '1',
                    post_image_url: '1',
                    slot_remain: '1',
                    place_start: '1',
                    place_end: '1',
                    day_total: '1',
                    dep_date: '1',
                    price: '1'
                },

            ];
            return el(
                'div',
                { className: 'tour-block-editor' },
                tours.map(function (tour, index) {
                    if (tour.dep_date !== '') {
                        return el(
                            'a',
                            { className: 'text-decoration-none', href: tour.post_link, key: index },
                            el(
                                'div',
                                { className: 'card mb-3' },
                                el(
                                    'div',
                                    { className: 'row g-0' },
                                    el(
                                        'div',
                                        { className: 'col-md-4' },
                                        el('img', { src: tour.post_image_url, className: 'img-fluid rounded-start', alt: '...' })
                                    ),
                                    el(
                                        'div',
                                        { className: 'col-md-5 d-flex align-items-center' },
                                        el(
                                            'div',
                                            { className: 'card-body' },
                                            el('h5', { className: 'card-title m-0 ' + (tour.slot_remain <= 0 ? 'text-decoration-line-through' : '') }, tour.post_title),
                                            el('p', { className: 'card-text m-0 my-3' }, tour.place_start + ' - ' + tour.place_end),
                                            el('p', { className: 'card-text m-0' }, 'Estimate: ' + tour.day_total + ' days')
                                        )
                                    ),
                                    el(
                                        'div',
                                        { className: 'col-md-3 d-flex align-items-center' },
                                        el(
                                            'div',
                                            { className: 'card-body' },
                                            el('p', { className: 'card-text mb-4' }, el('i', { className: 'bi bi-people-fill me-1' }), tour.slot_remain),
                                            el('p', { className: 'card-text mb-4' }, el('i', { className: 'bi bi-calendar2-minus me-1' }), tour.dep_date),
                                            el('span', { className: 'card-text px-3 py-2 rounded-4', style: { backgroundColor: '#f2b129' } }, el('i', { className: 'bi bi-coin' }), tour.price)
                                        )
                                    )
                                )
                            )
                        );
                    }
                    return null;
                })
            );
        },
        save: function (props) {
            var tours = [
                {
                    post_link: '1',
                    post_image_url: '1',
                    slot_remain: '1',
                    place_start: '1',
                    place_end: '1',
                    day_total: '1',
                    dep_date: '1',
                    price: '1'
                },
                {
                    post_link: '1',
                    post_image_url: '1',
                    slot_remain: '1',
                    place_start: '1',
                    place_end: '1',
                    day_total: '1',
                    dep_date: '1',
                    price: '1'
                },

            ];
            var abc = f;
            return el(
                'div',
                { className: 'tour-block-editor' },
                tours.map(function (tour, index) {
                    if (tour.dep_date !== '') {
                        return el(
                            'a',
                            { className: 'text-decoration-none', href: tour.post_link, key: index },
                            el(
                                'div',
                                { className: 'card mb-3' },
                                el(
                                    'div',
                                    { className: 'row g-0' },
                                    el(
                                        'div',
                                        { className: 'col-md-4' },
                                        el('img', { src: tour.post_image_url, className: 'img-fluid rounded-start', alt: '...' })
                                    ),
                                    el(
                                        'div',
                                        { className: 'col-md-5 d-flex align-items-center' },
                                        el(
                                            'div',
                                            { className: 'card-body' },
                                            el('h5', { className: 'card-title m-0 ' + (tour.slot_remain <= 0 ? 'text-decoration-line-through' : '') }, tour.post_title),
                                            el('p', { className: 'card-text m-0 my-3' }, tour.place_start + ' - ' + tour.place_end),
                                            el('p', { className: 'card-text m-0' }, 'Estimate: ' + tour.day_total + ' days')
                                        )
                                    ),
                                    el(
                                        'div',
                                        { className: 'col-md-3 d-flex align-items-center' },
                                        el(
                                            'div',
                                            { className: 'card-body' },
                                            el('p', { className: 'card-text mb-4' }, el('i', { className: 'bi bi-people-fill me-1' }), tour.slot_remain),
                                            el('p', { className: 'card-text mb-4' }, el('i', { className: 'bi bi-calendar2-minus me-1' }), tour.dep_date),
                                            el('span', { className: 'card-text px-3 py-2 rounded-4', style: { backgroundColor: '#f2b129' } }, el('i', { className: 'bi bi-coin' }), tour.price)
                                        )
                                    )
                                )
                            )
                        );
                    }
                    return null;
                })
            );
        }
    });
})(
    window.wp.blocks,
    window.wp.element,
    window.wp.editor,
    window.wp.components
);