import axios from "axios";
import authHeader from "./auth-header";

const API_URL = "http://localhost/api/v1/";

class MenuService {
    itemsPages = [
        {
            action: "image",
            active: false,
            title: "Pages",
            items: [
                {
                    title: "Profile",
                    prefix: "P",
                    active: false,
                    items: [
                        {
                            title: "Profile Overview",
                            prefix: "P",
                            link: "/pages/pages/profile/overview",
                        },
                        {
                            title: "All Projects",
                            prefix: "A",
                            link: "/pages/pages/profile/projects",
                        },
                        {
                            title: "Messages",
                            prefix: "M",
                            link: "/pages/pages/profile/messages",
                        },
                    ],
                },
                {
                    title: "Users",
                    prefix: "U",
                    active: false,
                    items: [
                        {
                            title: "Reports",
                            prefix: "R",
                            link: "/pages/pages/users/reports",
                        },
                        {
                            title: "New User",
                            prefix: "N",
                            link: "/pages/pages/users/new-user",
                        },
                    ],
                },
                {
                    title: "Account",
                    prefix: "A",
                    active: false,
                    items: [
                        {
                            title: "Settings",
                            prefix: "S",
                            link: "/pages/pages/account/settings",
                        },
                        {
                            title: "Billing",
                            prefix: "B",
                            link: "/pages/pages/account/billing",
                        },
                        {
                            title: "Invoice",
                            prefix: "I",
                            link: "/pages/pages/account/invoice",
                        },
                    ],
                },
                {
                    title: "Projects",
                    prefix: "P",
                    active: false,
                    items: [
                        {
                            title: "Timeline",
                            prefix: "T",
                            link: "/pages/pages/projects/timeline",
                        },
                    ],
                },
                {
                    title: "Virtual Reality",
                    prefix: "V",
                    active: false,
                    items: [
                        {
                            title: "VR Default",
                            prefix: "V",
                            link: "/pages/dashboards/vr/vr-default",
                        },
                        {
                            title: "VR Info",
                            prefix: "V",
                            link: "/pages/dashboards/vr/vr-info",
                        },
                    ],
                },
                {
                    title: "Pricing Page",
                    prefix: "P",
                    link: "/pages/pages/pricing-page",
                },
                { title: "RTL", prefix: "R", link: "/pages/pages/rtl" },
                { title: "Charts", prefix: "C", link: "/pages/pages/charts" },
                { title: "Alerts", prefix: "A", link: "/pages/pages/alerts" },
                {
                    title: "Notifications",
                    prefix: "N",
                    link: "/pages/pages/notifications",
                },
            ],
        },
        {
            action: "apps",
            active: false,
            title: "Applications",
            items: [
                { title: "CRM", prefix: "C", link: "/pages/dashboards/crm" },
                { title: "Kanban", prefix: "K", link: "/pages/applications/kanban" },
                { title: "Wizard", prefix: "W", link: "/pages/applications/wizard" },
                {
                    title: "DataTables",
                    prefix: "D",
                    link: "/pages/applications/datatables",
                },
                {
                    title: "Calendar",
                    prefix: "C",
                    link: "/pages/applications/calendar",
                },
            ],
        },
        {
            action: "shopping_basket",
            active: false,
            title: "Ecommerce",
            items: [
                {
                    title: "Products",
                    prefix: "P",
                    active: false,
                    items: [
                        {
                            title: "New Product",
                            prefix: "N",
                            link: "/pages/ecommerce/products/new-product",
                        },
                        {
                            title: "Edit Product",
                            prefix: "E",
                            link: "/pages/ecommerce/products/edit-product",
                        },
                        {
                            title: "Product Page",
                            prefix: "P",
                            link: "/pages/ecommerce/products/product-page",
                        },
                    ],
                },
                {
                    title: "Orders",
                    prefix: "O",
                    active: false,
                    items: [
                        {
                            title: "Order List",
                            prefix: "O",
                            link: "/pages/ecommerce/orders/list",
                        },
                        {
                            title: "Order Details",
                            prefix: "O",
                            link: "/pages/ecommerce/orders/details",
                        },
                    ],
                },
            ],
        },
        {
            action: "content_paste",
            active: false,
            title: "Authentication",
            items: [
                {
                    title: "Sign Up",
                    prefix: "S",
                    active: false,
                    items: [
                        {
                            title: "Basic",
                            prefix: "B",
                            link: "/pages/authentication/signup/basic",
                        },
                        {
                            title: "Cover",
                            prefix: "C",
                            link: "/pages/authentication/signup/cover",
                        },
                        {
                            title: "Illustration",
                            prefix: "I",
                            link: "/pages/authentication/signup/illustration",
                        },
                    ],
                },
            ],
        },
    ];

    getMenu() {
        return axios.get(API_URL + "profile/menu", { headers: authHeader() }).then(
            (response) => {
                this.mergeItems(this.itemsPages, response.data);
                return this.itemsPages;
            },
            (error) => {
                this.content =
                    (error.response && error.response.data) ||
                    error.message ||
                    error.toString();
            }
        );
    };

    mergeItems(itemsPages, newItems) {
        for (let key in newItems) {

            let found = itemsPages.find(item => item.title === newItems[key].title);
            if (found) {
                found.items = this.mergeNestedItems(found.items, newItems[key].items);
            } else {
                itemsPages.push({
                    action: newItems[key].action,
                    active: newItems[key].active,
                    title: newItems[key].title,
                    items: this.convertItemsObjectToArray(newItems[key].items)
                });
            }
        }
    };
    convertItemsObjectToArray(itemsObject) {
        let itemsArray = [];
        for (let key in itemsObject) {
            itemsArray.push({
                title: itemsObject[key].title,
                prefix: itemsObject[key].prefix,
                link: itemsObject[key].link,
                active: itemsObject[key].active,
                items: this.convertItemsObjectToArray(itemsObject[key].items)
            });
        }
        return itemsArray;
    };
    mergeNestedItems(oldItems, newItems) {
        let mergedItems = Array.isArray(oldItems) ? [...oldItems] : [];

        for (let key in newItems) {
            let found = mergedItems.find(item => item.title === newItems[key].title);
            if (found) {
                found.items = this.mergeNestedItems(found.items, newItems[key].items);
            } else {
                mergedItems.push({
                    title: newItems[key].title,
                    prefix: newItems[key].prefix,
                    link: newItems[key].link,
                    active: newItems[key].active,
                    items: this.convertItemsObjectToArray(newItems[key].items)
                });
            }
        }

        return mergedItems;
    }
}

export default new MenuService();
