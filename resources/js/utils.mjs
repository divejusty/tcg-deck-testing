import { DateTime } from 'luxon'

/**
 * Utility function to compare dates
 * @param {String} a ISO8601 compatible string
 * @param {String} b ISO8601 compatible string
 * @param {Boolean} descending Defaults to false
 * @returns {Number}
 */
const compareDates = (a, b, descending = false) => {
    let res = (DateTime.fromISO(a) <= DateTime.fromISO(b)) ? -1 : 1

    if (descending) {
        res *= -1
    }

    return res
}

export {
    compareDates
}
