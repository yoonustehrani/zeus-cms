import React, { Component } from 'react'

export default class MediaItem extends Component {
    render() {
        let { path, name, ext } = this.props
        return (
            <div className="media-item mt-4 col-4 col-md-3 col-lg-2">
                <div className="img-container mr-lg-2">
                    <img src={`${APP_PATH}${path}`} />
                </div>
                <p className="text-center text-primary">{name}.{ext}</p>
            </div>
        )
    }
}
