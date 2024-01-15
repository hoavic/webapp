export function getPermalink(item, props) {
    if (item.taxonomy === 'category') {
        return parseSlug(item);
    }
/*     console.log(props); */
    let term_slug = '';
    if(props.admin.taxonomies[item.taxonomy].rewrite) {
        term_slug = props.admin.taxonomies[item.taxonomy].rewrite;
    } else {
        term_slug = props.admin.taxonomies[item.taxonomy].taxonomy;
    }
    return '/' + term_slug + parseSlug(item);
}

export function parseSlug(item) {

    let slug = '';

    item.ancestors.forEach((ancestor) => {
        slug = slug + '/' + ancestor.term.slug;
    });

    return slug + '/' + item.term.slug;
}
