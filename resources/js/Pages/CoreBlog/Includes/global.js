export function stripHtml(dirtyString) {
    const doc = new DOMParser().parseFromString(dirtyString, 'text/html');
    return doc.body.textContent || '';
}
