export function stripHtml(dirtyString, def = '') {
    if(dirtyString === null) {return def}
    const doc = new DOMParser().parseFromString(dirtyString, 'text/html');
    return doc.body.textContent || '';
}
