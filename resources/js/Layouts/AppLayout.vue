<template>
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        <jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
          Dashboard
        </jet-nav-link>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <jet-dropdown id="settingsDropdown" classes="nav-item dropdown user-menu">
          <template #trigger>
            <img v-if="$page.props.jetstream.managesProfilePhotos" class="user-image img-circle elevation-1" width="32" height="32" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
            <span v-else class="d-none d-md-inline ml-2">{{ $page.props.user.name }}</span>

            <svg class="ml-2" width="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </template>

          <template #content>
            <!-- Account Management -->
            <h6 class="dropdown-header small text-muted">
              Manage Account
            </h6>

            <jet-dropdown-link :href="route('profile.show')">
              Profile
            </jet-dropdown-link>

            <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
              API Tokens
            </jet-dropdown-link>

            <hr class="dropdown-divider">

            <!-- Authentication -->
            <form @submit.prevent="logout">
              <jet-dropdown-link as="button">
                Log Out
              </jet-dropdown-link>
            </form>
          </template>
        </jet-dropdown>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-warning elevation-2">
      <!-- Brand Logo -->
      <a href="/" class="brand-link">
        <jet-application-mark width="36" class="brand-image img-circle elevation-1" style="opacity: .8" />
        <span class="brand-text font-weight-light">T.M.S</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div v-if="$page.props.jetstream.managesProfilePhotos" class="image">
            <img :src="$page.props.user.profile_photo_url" class="img-circle elevation-1" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{ $page.props.user.name }}</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item mt-2">
              <a href="/dashboard" class="nav-link bg-primary rounded">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                      Dashboard
                  </p>
              </a>
            </li>
            <!-- manage trucks -->
            <li class="nav-item has-treeview mt-2">
              <a class="nav-link bg-warning rounded">
                  <i class="nav-icon fas fa-th-large"></i>
                  <p>
                      Management
                      <i class="right fas fa-angle-left"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item ml-3">
                    <a href="/trucks" class="nav-link">
                        <i class="fa fa-truck nav-icon
                text-primary"></i>
                        <p>Trucks</p>
                    </a>
                </li>
                <li class="nav-item ml-3">
                    <a href="/track-record" class="nav-link ">
                        <i class="fa fa-folder-open nav-icon
                        text-success"></i>
                        <p>Track Records</p>
                    </a>
                </li>
                
                <li class="nav-item ml-3">
                    <a href="/dashboard" class="nav-link ">
                        <i class="fa fa-file nav-icon text-warning"></i>
                        <p>Invoices</p>
                    </a>
                </li>
                <li class="nav-item ml-3">
                    <a href="/drivers" class="nav-link">
                        <i class="fa fa-users nav-icon text-success"></i>
                        <p>Drivers</p>
                    </a>
                </li>
                <li class="nav-item ml-3">
                    <a href="/clients" class="nav-link ">
                        <i class="fa fa-shopping-cart nav-icon text-danger"></i>
                        <p>Clients</p>
                    </a>
                </li>
                <li class="nav-item ml-3">
                    <a href="/regions" class="nav-link ">
                        <i class="fa fa-globe nav-icon text-primary"></i>
                        <p>Regions</p>
                    </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview mt-2">
              <a class="nav-link bg-success rounded">
                  <i class="fa fa-briefcase nav-icon"></i>
                  <p>Finances</p>
                  <i class="right fas fa-angle-left"></i>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item ml-3">
                    <a href="/expense" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Financial Reports</p>
                    </a>
                </li>
                <li class="nav-item ml-3">
                    <a href="/bills" class="nav-link">
                        <i class="far fa-credit-card nav-icon" aria-hidden="true"></i>
                        <p>Pay Bills</p>
                    </a>
                </li>
                <li class="nav-item ml-3">
                    <a href="/expenses" class="nav-link">
                        <i class="far fa-circle nav-icon" aria-hidden="true"></i>
                        <p>Expenses</p>
                    </a>
                </li>
                <li class="nav-item ml-3">
                    <a href="/trucks" class="nav-link">
                        <i class="fa fa-university nav-icon"></i>
                        <p>Capital</p>
                    </a>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col">
              <h1><slot name="header"></slot></h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <jet-banner />

          <div class="row">
            <div class="col">
              <slot></slot>
            </div>
            <div v-show="hasSlot('aside')" class="col-lg-3">
              <slot name="aside"></slot>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b><a href="https://jetstream.laravel.com">Jetstream</a></b>
      </div>
      <strong>Powered by</strong> <a href="https://adminlte.io">AdminLTE</a>
    </footer>
  </div>
</template>

<script>
import JetApplicationLogo from '@/Jetstream/ApplicationLogo'
import JetBanner from '@/Jetstream/Banner'
import JetApplicationMark from '@/Jetstream/ApplicationMark'
import JetDropdown from '@/Jetstream/Dropdown'
import JetDropdownLink from '@/Jetstream/DropdownLink'
import JetNavLink from '@/Jetstream/NavLink'

export default {
  components: {
    JetApplicationLogo,
    JetApplicationMark,
    JetBanner,
    JetDropdown,
    JetDropdownLink,
    JetNavLink,
  },

  data() {
    return {
      showingNavigationDropdown: false,
    }
  },

  methods: {
    logout() {
      this.$inertia.post(route('logout'));
    },

    hasSlot (name = 'default') {
      return !!this.$slots[ name ];
    },
  },

  computed: {
    path() {
      return window.location.pathname
    }
  }
}
</script>
