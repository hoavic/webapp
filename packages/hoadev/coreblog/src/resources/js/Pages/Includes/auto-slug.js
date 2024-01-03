import slugify from "slugify";

export default function autoSlug(title) {
    return slugify(title, {lower: true, locale: 'vi'});
}
