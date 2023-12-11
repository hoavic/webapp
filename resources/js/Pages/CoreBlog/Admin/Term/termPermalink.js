export function getPermalink(item) {
    if (item.taxonomy === 'category') {
        return parseSlug(item);
    }
    return '/' + item.taxonomy + parseSlug(item);
}

export function parseSlug(item) {

    let slug = '';

    item.ancestors.forEach((ancestor) => {
        slug = slug + '/' + ancestor.term.slug;
    });

    return slug + '/' + item.term.slug;
}
