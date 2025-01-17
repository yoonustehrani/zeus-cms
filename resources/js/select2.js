export const formatOptionWithIcon = (option) => {
    if (option.element) {
        let icon_name = option.element.attributes.icon_name.nodeValue
        return $(`<div class="select-option"><i class="${icon_name}"></i>${option.text}</div>`)
    }
}

export const formatOptionWithText = (option) => {
    if (option.element) {
        return $(`<div class="select-option">${option.text}</div>`)
    }
}