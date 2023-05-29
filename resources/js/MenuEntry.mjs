class MenuEntry {
	/**
	 *
	 * @param {String} name
	 * @param {MenuEntry[]|String} target
	 */
	constructor(name, target) {
		this.name = name

		this.hasChildren = Array.isArray(target)

		if (this.hasChildren) {
			this.route = undefined
			this.children = target.map((item) => {
				return new MenuEntry(item.name, item.target)
			})
		} else {
			this.route = target
			this.children = []
		}
	}

	getName() {
		return this.name
	}

	getRoute() {
		return this.route
	}

	getChildren() {
		return this.children
	}

	isLeaf() {
		return !this.hasChildren
	}
}

export {
	MenuEntry
}
