<script setup>
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
import ApplicationLogo from '@/Components/Layout/ApplicationLogo.vue'
import NavLink from '@/Components/NavLink.vue'
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { MenuEntry } from '@/MenuEntry.mjs'
import { Link, usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

const showingNavigationDropdown = ref(false)

const props = defineProps({
	isAuthenticated: {
		type: Boolean,
		required: true,
	},
})

const leftItems = computed(() => {
	if (!props.isAuthenticated) {
		return []
	}

	let managementMenuItems = []
	/** @type {{ role: null|{permissions: [{ name: String }]} }} */
	const user = usePage().props.auth.user
	if (user.role && user.role.permissions.length > 0) {
		if (user.role.permissions.find((permission) => permission.name === 'archetypes')) {
			managementMenuItems.push({name: 'Archetypes', target: 'archetypes.index'})
		}
		if (user.role.permissions.find((permission) => permission.name === 'formats')) {
			managementMenuItems.push({name: 'Formats', target: 'formats.index'})
		}
		if (user.role.permissions.find((permission) => permission.name === 'sets')) {
			managementMenuItems.push({name: 'Sets', target: 'sets.index'})
		}
	}

	let menu = [
		new MenuEntry('Home', 'dashboard'),
		new MenuEntry('Decks', 'decks.index'),
		new MenuEntry('Testing Series', 'testing_series.index'),
	]

	if (managementMenuItems.length > 0) {
		menu.push(new MenuEntry('Management', managementMenuItems))
	}

	return menu
})
</script>

<template>
	<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
		<!-- Primary Navigation Menu -->
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex justify-between h-16">
				<div class="flex">
					<!-- Logo -->
					<div class="shrink-0 flex items-center">
						<Link :href="route('dashboard')">
							<ApplicationLogo
								class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"
							/>
						</Link>
					</div>

					<!-- Navigation Links -->
					<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
						<template v-for="(item, key) in leftItems"
								  :key="key">
							<NavLink v-if="item.isLeaf()"
									 :href="route(item.getRoute())"
									 :active="route().current(item.getRoute())"
							>
								{{ item.getName() }}
							</NavLink>

							<div class="sm:flex sm:items-center h-full" v-if="!item.isLeaf()">
								<Dropdown align="right" width="48">
									<template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button
											type="button"
											class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
										>
                                            {{ item.getName() }}

                                            <svg
												class="ml-2 -mr-0.5 h-4 w-4"
												xmlns="http://www.w3.org/2000/svg"
												viewBox="0 0 20 20"
												fill="currentColor"
											>
                                                <path
													fill-rule="evenodd"
													d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
													clip-rule="evenodd"
												/>
                                            </svg>
                                        </button>
                                    </span>
									</template>

									<template #content>
										<DropdownLink v-for="(subItem, subKey) in item.getChildren()"
													  :key="`${key}-${subKey}`"
													  :href="route(subItem.getRoute())"
										>
											{{ subItem.getName() }}
										</DropdownLink>
									</template>
								</Dropdown>
							</div>
						</template>

					</div>

				</div>

				<div class="hidden sm:flex sm:items-center sm:ml-6">


					<!-- Settings Dropdown -->
					<div class="ml-3 relative">
						<Dropdown align="right" width="48">
							<template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
									type="button"
									class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
								>
                                    {{ $page.props.auth.user.name }}

                                    <svg
										class="ml-2 -mr-0.5 h-4 w-4"
										xmlns="http://www.w3.org/2000/svg"
										viewBox="0 0 20 20"
										fill="currentColor"
									>
                                        <path
											fill-rule="evenodd"
											d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
											clip-rule="evenodd"
										/>
                                    </svg>
                                </button>
                            </span>
							</template>

							<template #content>
								<DropdownLink :href="route('profile.edit')"> Profile</DropdownLink>
								<DropdownLink :href="route('logout')" method="post" as="button">
									Log Out
								</DropdownLink>
							</template>
						</Dropdown>
					</div>
				</div>

				<!-- Hamburger -->
				<div class="-mr-2 flex items-center sm:hidden">
					<button
						@click="showingNavigationDropdown = !showingNavigationDropdown"
						class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
					>
						<svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
							<path
								:class="{
                                hidden: showingNavigationDropdown,
                                'inline-flex': !showingNavigationDropdown,
                            }"
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								d="M4 6h16M4 12h16M4 18h16"
							/>
							<path
								:class="{
                                hidden: !showingNavigationDropdown,
                                'inline-flex': showingNavigationDropdown,
                            }"
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								d="M6 18L18 6M6 6l12 12"
							/>
						</svg>
					</button>
				</div>
			</div>
		</div>

		<!-- Responsive Navigation Menu -->
		<div
			:class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
			class="sm:hidden"
		>
			<div class="pt-2 pb-3 space-y-1">
				<template v-for="(item, key) in leftItems"
						  :key="key"
				>
					<ResponsiveNavLink v-if="item.isLeaf()"
									   :href="route(item.getRoute())"
									   :active="route().current(item.getRoute())"
					>
						{{ item.getName() }}
					</ResponsiveNavLink>

					<template v-else>
						<div
							class="font-medium text-base text-gray-800 dark:text-gray-200 px-4 pt-4 border-t border-gray-200 dark:border-gray-600">
							{{ item.getName() }}
						</div>
						<ResponsiveNavLink :href="route(subItem.getRoute())"
										   :active="route().current(subItem.getRoute())"
										   v-for="(subItem, subKey) in item.getChildren()"
										   :key="`${key}-${subKey}`"
						>
							{{ subItem.getName() }}
						</ResponsiveNavLink>

					</template>
				</template>

			</div>

			<!-- Responsive Settings Options -->
			<div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
				<div class="px-4">
					<div class="font-medium text-base text-gray-800 dark:text-gray-200">
						{{ $page.props.auth.user.name }}
					</div>
					<div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
				</div>

				<div class="mt-3 space-y-1">
					<ResponsiveNavLink :href="route('profile.edit')"> Profile</ResponsiveNavLink>
					<ResponsiveNavLink :href="route('logout')" method="post" as="button">
						Log Out
					</ResponsiveNavLink>
				</div>
			</div>
		</div>
	</nav>
</template>
