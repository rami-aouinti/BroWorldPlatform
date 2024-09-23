import Vue from "vue";
import VueRouter from "vue-router";
import DashboardLayout from "../views/Layout/DashboardLayout.vue";
import ProfileLayout from "../views/Layout/ProfileLayout.vue";
import DashboardLayoutVr from "../views/Layout/DashboardLayoutVr.vue";
import PageLayout from "../views/Layout/PageLayout";
import PageTypeLayout from "../views/Platform/Layout/PageTypeLayout";
import AuthBasicLayout from "../views/Layout/AuthBasicLayout";
import AuthCoverLayout from "../views/Layout/AuthCoverLayout";
import AuthIllustrationLayout from "../views/Layout/AuthIllustrationLayout";
import Checkout from "../views/Ecommerce/Process/Checkout.vue";


// Dashboard pages
const Dashboard = () => import("../views/Dashboard/Dashboard.vue");
const Discover = () => import("../views/Dashboard/Discover.vue");
const Automotive = () => import("../views/Dashboard/Automotive.vue");
const Sales = () => import("../views/Dashboard/Sales.vue");
const SmartHome = () => import("../views/Dashboard/SmartHome.vue");
const Quiz = () => import("../views/Dashboard/Quiz.vue");
const QuizQuestion = () => import("../components/Question.vue");
const Score = () => import("../components/Score.vue");

const VrDefault = () => import("../views/Dashboard/VrDefault.vue");
const VrInfo = () => import("../views/Dashboard/VrInfo.vue");
const Crm = () => import("../views/Dashboard/Crm.vue");
const GettingStarted = () => import("../views/Dashboard/GettingStarted.vue");

// Pages
const Pricing = () =>
  import(/* webpackChunkName: "pages" */ "@/views/Pages/Pricing.vue");
const Rtl = () =>
  import(/* webpackChunkName: "pages" */ "@/views/Pages/Rtl.vue");
const ProfileOverview = () =>
  import(
    /* webpackChunkName: "pages" */ "@/views/Pages/Profile/ProfileOverview.vue"
  );
const Messages = () =>
  import(/* webpackChunkName: "pages" */ "@/views/Pages/Profile/Messages.vue");
const Projects = () =>
  import(/* webpackChunkName: "pages" */ "@/views/Pages/Profile/Projects.vue");
const Reports = () =>
  import(/* webpackChunkName: "pages" */ "@/views/Pages/Users/Reports.vue");
const NewUser = () =>
  import(/* webpackChunkName: "pages" */ "@/views/Pages/Users/NewUser.vue");
const Settings = () =>
  import(/* webpackChunkName: "pages" */ "@/views/Pages/Account/Settings.vue");
const Billing = () =>
  import(/* webpackChunkName: "pages" */ "@/views/Pages/Account/Billing.vue");
const Invoice = () =>
  import(/* webpackChunkName: "pages" */ "@/views/Pages/Account/Invoice.vue");
const Timeline = () =>
  import(/* webpackChunkName: "pages" */ "@/views/Pages/Projects/Timeline.vue");
const Charts = () =>
  import(/* webpackChunkName: "pages" */ "@/views/Pages/Charts.vue");
const Alerts = () =>
  import(/* webpackChunkName: "pages" */ "@/views/Pages/Alerts.vue");
const Notifications = () =>
  import(/* webpackChunkName: "pages" */ "@/views/Pages/Notifications.vue");
const SignUpBasic = () =>
  import(
    /* webpackChunkName: "pages" */ "@/views/Pages/Authentication/SignUp/Basic.vue"
  );
const SignUpCover = () =>
  import(
    /* webpackChunkName: "pages" */ "@/views/Pages/Authentication/SignUp/Cover.vue"
  );
const SignUpIllustration = () =>
  import(
    /* webpackChunkName: "pages" */ "@/views/Pages/Authentication/SignUp/Illustration.vue"
  );

// Applications
const Kanban = () =>
  import(/* webpackChunkName: "pages" */ "@/views/Applications/Kanban.vue");
const Wizard = () =>
  import(/* webpackChunkName: "pages" */ "@/views/Applications/Wizard.vue");
const Datatables = () =>
  import(/* webpackChunkName: "pages" */ "@/views/Applications/Datatables.vue");
const Calendar = () =>
  import(/* webpackChunkName: "pages" */ "@/views/Applications/Calendar.vue");

// Ecommerce
const NewProduct = () =>
  import(
    /* webpackChunkName: "pages" */ "@/views/Ecommerce/Products/NewProduct.vue"
  );
const EditProduct = () =>
  import(
    /* webpackChunkName: "pages" */ "@/views/Ecommerce/Products/EditProduct.vue"
  );
const ProductPage = () =>
  import(
    /* webpackChunkName: "pages" */ "@/views/Ecommerce/Products/ProductPage.vue"
  );
const OrderList = () =>
  import(
    /* webpackChunkName: "pages" */ "@/views/Ecommerce/Orders/OrderList.vue"
  );
const OrderDetails = () =>
  import(
    /* webpackChunkName: "pages" */ "@/views/Ecommerce/Orders/OrderDetails.vue"
  );

const Login = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Auth/Login.vue");

const AdminDatatables = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Applications/AdminDatatables.vue");

const AdminUserDatatables = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Admin/UserDatatables.vue");

const AdminConfigurationDatatables = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Admin/ConfigurationDatatables.vue");

const AdminMenuDatatables = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Admin/MenuDatatables.vue");


const Admin = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Admin/Dashboard.vue");

const AdminUsers = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Admin/Management/UserManagement/User/Datatables.vue");


const AdminUsersGroup = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Admin/Management/UserManagement/Group/Datatables.vue");


const AdminUsersRole = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Admin/Management/UserManagement/Role/Datatables.vue");

const AdminShop = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Admin/Management/ShopManagement/Dashboard.vue");

const AdminShopCategory = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Admin/Management/ShopManagement/Category/Datatables.vue");

const AdminShopProduct = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Admin/Management/ShopManagement/Product/Datatables.vue");

const AdminShopOrder = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Admin/Management/ShopManagement/Order/Datatables.vue");

const Blog = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Blog/Blog.vue");

const CrmVue = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Crm/Crm.vue");

const Shop = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Ecommerce/Shop.vue");

const Library = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Library/Library.vue");

const Profile = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Profile/Profile.vue");

const Setting = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Profile/Setting.vue");

const Project = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Projects/Project.vue");


const QuizVue = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Quiz/Quiz.vue");

const Resume = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Resume/Resume.vue");

const Job = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Job/Job.vue");

const JobDetail = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Job/Job/JobDetail.vue");

const ProductDetail = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Ecommerce/Product/ProductDetail.vue");

const NewProductShop = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Ecommerce/Product/NewProduct.vue");


const CheckoutShop = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Ecommerce/Process/Checkout.vue");

const PaymentShop = () =>
    import(/* webpackChunkName: "pages" */ "@/views/Platform/Ecommerce/Process/Paiement.vue");


Vue.use(VueRouter);

let vrPages = {
  path: "/",
  component: DashboardLayoutVr,
  name: "Vr",
  children: [
    {
      path: "/pages/dashboards/vr/vr-default",
      name: "VrDefault",
      component: VrDefault,
      meta: {
        groupName: "Dashboards",
      },
    },
    {
      path: "/pages/dashboards/vr/vr-info",
      name: "VrInfo",
      component: VrInfo,
      meta: {
        groupName: "Dashboards",
      },
    },
  ],
};

let profilePages = {
  path: "/",
  component: ProfileLayout,
  name: "Profile",
  children: [
    {
      path: "/pages/pages/profile/overview",
      name: "ProfileOverview",
      component: ProfileOverview,
      meta: {
        groupName: "Pages",
      },
    },
    {
      path: "/pages/pages/profile/messages",
      name: "Messages",
      component: Messages,
      meta: {
        groupName: "Pages",
      },
    },
    {
      path: "/pages/pages/profile/projects",
      name: "Project",
      component: Projects,
      meta: {
        groupName: "Pages",
      },
    },
  ],
};

let userPages = {
  path: "/",
  component: DashboardLayout,
  name: "Users",
  children: [
    {
      path: "/pages/pages/users/reports",
      name: "Reports",
      component: Reports,
      meta: {
        groupName: "Pages",
      },
    },
    {
      path: "/pages/pages/users/new-user",
      name: "NewUser",
      component: NewUser,
      meta: {
        groupName: "Pages",
      },
    },
  ],
};

let accountPages = {
  path: "/",
  component: DashboardLayout,
  name: "Account",
  children: [
    {
      path: "/pages/pages/account/settings",
      name: "Settings",
      component: Settings,
      meta: {
        groupName: "Pages",
      },
    },
    {
      path: "/pages/pages/account/billing",
      name: "Billing",
      component: Billing,
      meta: {
        groupName: "Pages",
      },
    },
    {
      path: "/pages/pages/account/invoice",
      name: "Invoice",
      component: Invoice,
      meta: {
        groupName: "Pages",
      },
    },
  ],
};

let projectsPages = {
  path: "/",
  component: DashboardLayout,
  name: "Projects",
  children: [
    {
      path: "/pages/pages/projects/timeline",
      name: "Timeline",
      component: Timeline,
      meta: {
        groupName: "Pages",
      },
    },
  ],
};

let applicationPages = {
  path: "/",
  component: DashboardLayout,
  name: "Application",
  children: [
    {
      path: "/pages/applications/kanban",
      name: "Kanban",
      component: Kanban,
      meta: {
        groupName: "Applications",
      },
    },
    {
      path: "/pages/applications/wizard",
      name: "Wizard",
      component: Wizard,
      meta: {
        groupName: "Applications",
      },
    },
    {
      path: "/pages/applications/datatables",
      name: "Datatables",
      component: Datatables,
      meta: {
        groupName: "Applications",
      },
    },
    {
      path: "/pages/applications/calendar",
      name: "Calendar",
      component: Calendar,
      meta: {
        groupName: "Applications",
      },
    },
  ],
};

let pricingPage = {
  path: "/pricing",
  component: PageLayout,
  name: "Pricing Page",
  children: [
    {
      path: "/pages/pages/pricing-page",
      name: "Pricing",
      component: Pricing,
    },
  ],
};

let authBasicPages = {
  path: "/",
  component: AuthBasicLayout,
  name: "Authentication Basic",
  children: [
    {
      path: "/pages/authentication/signup/basic",
      name: "SignUpBasic",
      component: SignUpBasic,
    },
  ],
};

let authCoverPages = {
  path: "/",
  component: AuthCoverLayout,
  name: "Authentication Cover",
  children: [
    {
      path: "/pages/authentication/signup/cover",
      name: "SignUpCover",
      component: SignUpCover,
    },
  ],
};

let authIllustrationPages = {
  path: "/",
  component: AuthIllustrationLayout,
  name: "Authentication Illustration",
  children: [
    {
      path: "/pages/authentication/signup/illustration",
      name: "SignUpIllustration",
      component: SignUpIllustration,
    },
  ],
};


let blog = {
    path: "/",
    component: PageTypeLayout,
    name: "Blog",
    children: [
        {
            path: "/",
            name: "Blog",
            component: Blog,
        },
    ],
};

let admin = {
    path: "/",
    component: PageTypeLayout,
    name: "Admin",
    children: [
        {
            path: "/admin",
            name: "Admin",
            component: Admin,
        },
    ],
};

let adminUsers = {
    path: "/",
    component: PageTypeLayout,
    name: "AdminUsers",
    children: [
        {
            path: "/admin/users",
            name: "AdminUsers",
            component: AdminUsers,
        },
    ],
};

let adminUsersGroup = {
    path: "/",
    component: PageTypeLayout,
    name: "AdminUsersGroup",
    children: [
        {
            path: "/admin/user/groups",
            name: "AdminUsersGroup",
            component: AdminUsersGroup,
        },
    ],
};

let adminUsersRole = {
    path: "/",
    component: PageTypeLayout,
    name: "AdminUsersRole",
    children: [
        {
            path: "/admin/users/roles",
            name: "AdminUsersRole",
            component: AdminUsersRole,
        },
    ],
};

let adminShop = {
    path: "/",
    component: PageTypeLayout,
    name: "AdminShop",
    children: [
        {
            path: "/admin/shop",
            name: "AdminShop",
            component: AdminShop,
        },
    ],
};

let adminShopCategory = {
    path: "/",
    component: PageTypeLayout,
    name: "AdminShopCategory",
    children: [
        {
            path: "/admin/shop/category",
            name: "AdminShopCategory",
            component: AdminShopCategory,
        },
    ],
};

let adminShopProduct = {
    path: "/",
    component: PageTypeLayout,
    name: "AdminShopProduct",
    children: [
        {
            path: "/admin/shop/product",
            name: "AdminShopProduct",
            component: AdminShopProduct,
        },
    ],
};

let adminShopOrder = {
    path: "/",
    component: PageTypeLayout,
    name: "AdminShopOrder",
    children: [
        {
            path: "/admin/shop/order",
            name: "AdminShopOrder",
            component: AdminShopOrder,
        },
    ],
};

let login = {
    path: "/login",
    component: AuthBasicLayout,
    name: "Authentication Basic",
    children: [
        {
            path: "/login",
            name: "Login",
            component: Login,
        },
    ],
};

let register = {
    path: "/",
    component: AuthBasicLayout,
    name: "Authentication Basic",
    children: [
        {
            path: "/register",
            name: "Register",
            component: Login,
        },
    ],
};

let logout = {

    path: '/logout',
    name: 'logout',
    beforeEnter(to, from, next) {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        next('/login');
    }
}

let crm = {
    path: "/",
    component: PageTypeLayout,
    name: "Crm",
    children: [
        {
            path: "/crm",
            name: "Crm",
            component: CrmVue,
        },
    ],
};

let ecommerce = {
    path: "/",
    component: PageTypeLayout,
    name: "Ecommerce",
    children: [
        {
            path: "/ecommerce",
            name: "Ecommerce",
            component: Shop,
        },
    ],
};

let library = {
    path: "/",
    component: PageTypeLayout,
    name: "Library",
    children: [
        {
            path: "/library",
            name: "Library",
            component: Library,
        },
    ],
};

let profile = {
    path: "/",
    component: PageTypeLayout,
    name: "Profile",
    children: [
        {
            path: "/profile",
            name: "Profile",
            component: Profile,
        },
    ],
};

let setting = {
    path: "/",
    component: PageTypeLayout,
    name: "Setting",
    children: [
        {
            path: "/setting",
            name: "Setting",
            component: Setting,
        },
    ],
};

let project = {
    path: "/",
    component: PageTypeLayout,
    name: "Project",
    children: [
        {
            path: "/project",
            name: "Projects",
            component: Project,
        },
    ],
};

let quiz = {
    path: "/",
    component: PageTypeLayout,
    name: "Authentication Basic",
    children: [
        {
            path: "/quiz",
            name: "Quiz",
            component: QuizVue,
            meta: {
                groupName: "Application",
            },
        },
    ],
};

let resume = {
    path: "/",
    component: PageTypeLayout,
    name: "Resume",
    children: [
        {
            path: "/resume",
            name: "Resume",
            component: Resume,
            meta: {
                groupName: "Application",
            },
        },
    ],
};

let job = {
    path: "/",
    component: PageTypeLayout,
    name: "Job",
    children: [
        {
            path: "/job",
            name: "Job",
            component: Job,
            meta: {
                groupName: "Application",
            },
        },
    ],
};

let jobDetail = {
    path: "/",
    component: PageTypeLayout,
    name: "JobDetail",
    children: [
        {
            path: "/job/:id",
            name: "JobDetail",
            component: JobDetail,
            meta: {
                groupName: "Job",
            },
            props: true
        },
    ],
};

let productDetail = {
    path: "/",
    component: PageTypeLayout,
    name: "ProductDetail",
    children: [
        {
            path: "/product/:id",
            name: "ProductDetail",
            component: ProductDetail,
            meta: {
                groupName: "Shop",
            },
            props: true
        },
    ],
};

let newProduct = {
    path: "/",
    component: PageTypeLayout,
    name: "newProduct",
    children: [
        {
            path: "/product/new",
            name: "newProduct",
            component: NewProductShop,
            meta: {
                groupName: "Shop",
            },
            props: true
        },
    ],
};


let checkout = {
    path: "/",
    component: PageTypeLayout,
    name: "checkout",
    children: [
        {
            path: "/shop/checkout",
            name: "checkout",
            component: CheckoutShop,
            meta: {
                groupName: "Shop",
            },
            props: true
        },
    ],
};

let payment = {
    path: "/",
    component: PageTypeLayout,
    name: "payment",
    children: [
        {
            path: "/shop/payment",
            name: "payment",
            component: PaymentShop,
            meta: {
                groupName: "Shop",
            },
            props: true
        },
    ],
};

let messenger = {
    path: "/",
    component: PageTypeLayout,
    name: "Authentication Basic",
    children: [
        {
            path: "/messenger",
            name: "Messenger",
            component: Login,
        },
    ],
};

const routes = [
    blog,
    admin,
    adminUsers,
    adminUsersGroup,
    adminUsersRole,
    adminShop,
    adminShopCategory,
    adminShopProduct,
    adminShopOrder,
    login,
    logout,
    register,
    crm,
    ecommerce,
    library,
    profile,
    setting,
    project,
    quiz,
    resume,
    messenger,
    job,
    jobDetail,
    productDetail,
    newProduct,
    checkout,
    payment,
  {
    path: "/pages",
    name: "Dashboard",
    redirect: "/pages/dashboards/analytics",
    component: DashboardLayout,
    children: [
        {
            path: "pages/dashboards/admin",
            name: "Admin",
            component: AdminDatatables,
            meta: {
                groupName: "Admin",
            },
        },
        {
            path: "pages/dashboards/admin/user",
            name: "Admin User",
            component: AdminUserDatatables,
            meta: {
                groupName: "Admin",
            },
        },
        {
            path: "pages/dashboards/admin/configuration",
            name: "Admin Configuration",
            component: AdminConfigurationDatatables,
            meta: {
                groupName: "Admin",
            },
        },
        {
            path: "pages/dashboards/admin/menu",
            name: "Admin Menu",
            component: AdminMenuDatatables,
            meta: {
                groupName: "Admin",
            },
        },
      {
        path: "pages/dashboards/analytics",
        name: "Analytics",
        component: Dashboard,
        meta: {
          groupName: "Dashboards",
        },
      },
      {
        path: "pages/dashboards/discover",
        name: "Discover",
        component: Discover,
        meta: {
          groupName: "Dashboards",
        },
      },
        {
            path: "/pages/dashboards/quiz",
            name: "Quiz",
            component: Quiz,
            meta: {
                groupName: "Dashboards",
            },
        },
        {
            path: '/question/:id',
            name: 'Quiz',
            component: QuizQuestion,
            props: true, // Permet de passer les paramètres comme props
        },
        {
            path: '/score',
            name: 'Score',
            component: Score,
            props: true, // Permet de passer les paramètres comme props
        },
      {
        path: "/pages/dashboards/smart-home",
        name: "SmartHome",
        component: SmartHome,
        meta: {
          groupName: "Dashboards",
        },
      },
      {
        path: "/pages/dashboards/crm",
        name: "Crm",
        component: Crm,
        meta: {
          groupName: "Components",
        },
      },
      {
        path: "/pages/dashboards/automotive",
        name: "Automotive",
        component: Automotive,
        meta: {
          groupName: "Dashboards",
        },
      },
      {
        path: "/pages/dashboards/sales",
        name: "Sales",
        component: Sales,
        meta: {
          groupName: "Dashboards",
        },
      },
      {
        path: "/pages/pages/rtl",
        name: "RTL",
        component: Rtl,
        meta: {
          groupName: "Components",
        },
      },
      {
        path: "/pages/pages/charts",
        name: "Charts",
        component: Charts,
        meta: {
          groupName: "Components",
        },
      },
      {
        path: "/pages/pages/alerts",
        name: "Alerts",
        component: Alerts,
        meta: {
          groupName: "Components",
        },
      },
      {
        path: "/pages/pages/notifications",
        name: "Notifications",
        component: Notifications,
        meta: {
          groupName: "Components",
        },
      },
      {
        path: "getting-started",
        name: "Getting Started",
        component: GettingStarted,
        meta: {
          groupName: "Components",
        },
      },
      {
        path: "/pages/ecommerce/products/new-product",
        name: "NewProduct",
        component: NewProduct,
        meta: {
          groupName: "Ecommerce",
        },
      },
      {
        path: "/pages/ecommerce/products/edit-product",
        name: "EditProduct",
        component: EditProduct,
        meta: {
          groupName: "Ecommerce",
        },
      },
      {
        path: "/pages/ecommerce/products/product-page",
        name: "ProductPage",
        component: ProductPage,
        meta: {
          groupName: "Ecommerce",
        },
      },
      {
        path: "/pages/ecommerce/orders/list",
        name: "OrderList",
        component: OrderList,
        meta: {
          groupName: "Ecommerce",
        },
      },
      {
        path: "/pages/ecommerce/orders/details",
        name: "OrderDetails",
        component: OrderDetails,
        meta: {
          groupName: "Ecommerce",
        },
      },
    ],
  },
  pricingPage,
  profilePages,
  applicationPages,
  userPages,
  accountPages,
  projectsPages,
  vrPages,
  authBasicPages,
  authCoverPages,
  authIllustrationPages
];

const router = new VueRouter({
  routes,
});

export default router;
